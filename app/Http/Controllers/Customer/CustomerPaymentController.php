<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Detail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerPaymentController extends Controller
{
    /**
     * Display payment portal - shows form or user details
     */
    public function index()
    {
        // Check if user credentials are in session
        if (session('payment_user_id')) {
            $user = User::find(session('payment_user_id'));
            $userDetail = Detail::where('user_id', session('payment_user_id'))->first();
            
            if ($user && $userDetail) {
                // Get current month's unpaid billing
                $currentBilling = Billing::where('user_id', $user->id)
                    ->where('status', '!=', 'paid')
                    ->orderBy('created_at', 'desc')
                    ->first();
                
                return view('customer.payments.index', compact('user', 'userDetail', 'currentBilling'));
            }
        }
        
        // Show credential form
        return view('customer.payments.index');
    }

    /**
     * Verify user credentials
     */
    public function verify(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'pin' => 'required|string|min:4',
        ]);

        // Find user by phone and PIN in details table
        $detail = Detail::where('phone', $request->phone)
            ->where('pin', $request->pin)
            ->whereNotNull('user_id')
            ->first();

        if (!$detail) {
            return back()->with('error', 'Invalid mobile number or PIN. Please check and try again.');
        }

        $user = $detail->user;

        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        // Store in session
        session([
            'payment_user_id' => $user->id,
            'payment_phone' => $request->phone,
            'payment_pin' => $request->pin
        ]);

        return redirect()->route('customer.payments');
    }

    /**
     * Process payment
     */
    public function process(Request $request)
    {
        $request->validate([
            'billing_id' => 'required|exists:billings,id',
            'payment_method' => 'required|in:bkash,cash,bank',
        ]);

        $customer = Auth::guard('customer')->user();
        
        // Verify session
        if (!session('payment_user_id')) {
            return back()->with('error', 'Session expired. Please verify credentials again.');
        }

        // Get billing
        $billing = Billing::where('id', $request->billing_id)
            ->where('user_id', session('payment_user_id'))
            ->where('status', '!=', 'paid')
            ->first();

        if (!$billing) {
            return back()->with('error', 'Billing not found or already paid.');
        }

        // Verify phone and PIN again
        $detail = Detail::where('user_id', $billing->user_id)
            ->where('phone', session('payment_phone'))
            ->where('pin', session('payment_pin'))
            ->first();

        if (!$detail) {
            return back()->with('error', 'Verification failed. Invalid credentials.');
        }

        try {
            DB::beginTransaction();

            // 1. Create payment record (Admin Payment Table)
            $payment = Payment::create([
                'billing_id' => $billing->id,
                'user_id' => $billing->user_id,
                'customer_id' => $customer->id,
                'invoice' => $billing->invoice,
                'payment_method' => $request->payment_method,
                'package_price' => $billing->package_price,
                'status' => 'completed',
            ]);

            // 2. Update billing status (Admin Billing Table)
            $billing->update([
                'status' => 'paid',
                'paid_amount' => $billing->package_price,
                'due_amount' => 0,
            ]);

            // 3. Create invoice record (Customer Invoice Table)
            $invoiceId = null;
            try {
                $invoice = Invoice::create([
                    'invoice_number' => $billing->invoice,
                    'customer_id' => $customer->id,
                    'billing_id' => $billing->id,
                    'payment_id' => $payment->id,
                    'package_name' => $billing->package_name,
                    'amount' => $billing->package_price,
                    'paid_amount' => $billing->package_price,
                    'status' => 'paid',
                    'payment_method' => $request->payment_method,
                    'issue_date' => $billing->created_at,
                    'due_date' => Carbon::parse($billing->created_at)->addMonth(),
                    'paid_date' => now(),
                ]);
                $invoiceId = $invoice->id;
            } catch (\Exception $e) {
                Log::warning('Could not create invoice: ' . $e->getMessage());
            }

            // 4. Update user detail due amount
            if ($detail->due >= $billing->package_price) {
                $detail->update([
                    'due' => $detail->due - $billing->package_price,
                ]);
            } else {
                $detail->update([
                    'due' => 0,
                ]);
            }

            DB::commit();

            // Clear session
            session()->forget(['payment_user_id', 'payment_phone', 'payment_pin']);

            return redirect()->route('customer.payment.success')
                ->with('success', 'Payment completed successfully!')
                ->with('payment_amount', $billing->package_price)
                ->with('user_name', $billing->user->name)
                ->with('invoice_id', $invoiceId);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment processing error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Payment processing failed. Please try again. Error: ' . $e->getMessage());
        }
    }

    /**
     * Show payment success page
     */
    public function success()
    {
        if (!session('success')) {
            return redirect()->route('customer.payments');
        }

        return view('customer.payments.success');
    }

    /**
     * Process bKash payment
     */
    public function bkashPayment($billingId)
    {
        if (!session('payment_user_id')) {
            return redirect()->route('customer.payments')
                ->with('error', 'Session expired. Please verify credentials again.');
        }

        $billing = Billing::where('id', $billingId)
            ->where('user_id', session('payment_user_id'))
            ->where('status', '!=', 'paid')
            ->firstOrFail();

        // Store billing ID in session for bKash callback
        session(['bkash_billing_id' => $billingId]);

        // Redirect to bKash payment gateway
        return redirect()->route('bkash-create-payment', ['param' => $billingId . '_customer_' . auth('customer')->id()]);
    }

    /**
     * Handle bKash callback
     */
    public function bkashCallback(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        
        if (!session('bkash_billing_id') || !session('payment_user_id')) {
            return redirect()->route('customer.payments')
                ->with('error', 'Payment session expired.');
        }

        $billingId = session('bkash_billing_id');
        $billing = Billing::findOrFail($billingId);

        try {
            DB::beginTransaction();

            // 1. Create payment record
            $payment = Payment::create([
                'billing_id' => $billing->id,
                'user_id' => $billing->user_id,
                'customer_id' => $customer->id,
                'invoice' => $billing->invoice,
                'payment_method' => 'bkash',
                'package_price' => $billing->package_price,
                'transaction_id' => $request->get('trxID', null),
                'status' => 'completed',
            ]);

            // 2. Update billing
            $billing->update([
                'status' => 'paid',
                'paid_amount' => $billing->package_price,
                'due_amount' => 0,
            ]);

            // 3. Create invoice
            $invoiceId = null;
            try {
                $invoice = Invoice::create([
                    'invoice_number' => $billing->invoice,
                    'customer_id' => $customer->id,
                    'billing_id' => $billing->id,
                    'payment_id' => $payment->id,
                    'package_name' => $billing->package_name,
                    'amount' => $billing->package_price,
                    'paid_amount' => $billing->package_price,
                    'status' => 'paid',
                    'payment_method' => 'bkash',
                    'issue_date' => $billing->created_at,
                    'due_date' => Carbon::parse($billing->created_at)->addMonth(),
                    'paid_date' => now(),
                ]);
                $invoiceId = $invoice->id;
            } catch (\Exception $e) {
                Log::warning('Could not create invoice: ' . $e->getMessage());
            }

            // 4. Update detail
            $detail = Detail::where('user_id', $billing->user_id)->first();
            if ($detail && $detail->due >= $billing->package_price) {
                $detail->update(['due' => $detail->due - $billing->package_price]);
            }

            DB::commit();

            // Clear sessions
            session()->forget(['bkash_billing_id', 'payment_user_id', 'payment_phone', 'payment_pin']);

            return redirect()->route('customer.payment.success')
                ->with('success', 'Payment completed successfully via bKash!')
                ->with('payment_amount', $billing->package_price)
                ->with('user_name', $billing->user->name)
                ->with('invoice_id', $invoiceId);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('bKash callback error: ' . $e->getMessage());
            return redirect()->route('customer.payments')
                ->with('error', 'Payment processing failed: ' . $e->getMessage());
        }
    }

    /**
     * View invoice in browser
     */
    public function viewInvoice($invoiceId)
    {
        $customer = Auth::guard('customer')->user();
        
        $invoice = Invoice::where('id', $invoiceId)
            ->where('customer_id', $customer->id)
            ->with(['billing', 'payment'])
            ->firstOrFail();

        return view('customer.payments.invoice', compact('invoice', 'customer'));
    }

    /**
     * Download invoice as PDF
     */
    public function downloadInvoice($invoiceId)
    {
        $customer = Auth::guard('customer')->user();
        
        $invoice = Invoice::where('id', $invoiceId)
            ->where('customer_id', $customer->id)
            ->with(['billing', 'payment'])
            ->firstOrFail();

        // Generate PDF
        $pdf = Pdf::loadView('customer.payments.invoice-pdf', compact('invoice', 'customer'));
        
        $filename = 'Invoice-' . $invoice->invoice_number . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Get payment history with invoices
     */
    public function history()
    {
        $customer = Auth::guard('customer')->user();
        
        // Get all invoices for this customer
        $invoices = Invoice::where('customer_id', $customer->id)
            ->with(['billing', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('customer.payments.history', compact('invoices', 'customer'));
    }
}