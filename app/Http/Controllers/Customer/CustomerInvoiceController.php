<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Billing;
use App\Models\User;
use App\Models\Detail;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerInvoiceController extends Controller
{
    /**
     * Display a listing of invoices
     */
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        
        // Find associated user by email
        $user = User::where('email', $customer->email)->first();
        
        if (!$user) {
            return view('customer.invoices', [
                'customer' => $customer,
                'invoices' => collect(),
                'paidAmount' => 0,
                'pendingAmount' => 0,
            ]);
        }

        // Get all invoices for this user
        $invoices = Billing::where('user_id', $user->id)
            ->with('package')
            ->orderBy('billing_date', 'desc')
            ->paginate(10);

        // Calculate paid and pending amounts
        $paidAmount = Billing::where('user_id', $user->id)
            ->where('status', 'paid')
            ->sum('package_price');

        $pendingAmount = Billing::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'unpaid'])
            ->sum('package_price');

        return view('customer.invoices', compact(
            'customer',
            'invoices',
            'paidAmount',
            'pendingAmount'
        ));
    }

    /**
     * Display a specific invoice
     */
    public function show($id)
    {
        $customer = Auth::guard('customer')->user();
        
        // Find associated user by email
        $user = User::where('email', $customer->email)->first();
        
        if (!$user) {
            return redirect()->route('customer.invoices')
                ->with('error', 'User account not found.');
        }

        // Get the invoice
        $invoice = Billing::where('id', $id)
            ->where('user_id', $user->id)
            ->with(['package', 'user.detail'])
            ->firstOrFail();

        // Get user details
        $detail = Detail::where('user_id', $user->id)->first();

        return view('customer.invoice-detail', compact(
            'customer',
            'invoice',
            'user',
            'detail'
        ));
    }

    /**
     * Download invoice as PDF
     */
    public function download($id)
    {
        $customer = Auth::guard('customer')->user();
        
        // Find associated user by email
        $user = User::where('email', $customer->email)->first();
        
        if (!$user) {
            return redirect()->route('customer.invoices')
                ->with('error', 'User account not found.');
        }

        // Get the invoice
        $invoice = Billing::where('id', $id)
            ->where('user_id', $user->id)
            ->with(['package', 'user.detail'])
            ->firstOrFail();

        // Get user details
        $detail = Detail::where('user_id', $user->id)->first();

        // Generate PDF
        $pdf = Pdf::loadView('customer.invoice-pdf', compact(
            'customer',
            'invoice',
            'user',
            'detail'
        ));

        $invoiceNumber = str_pad($invoice->id, 6, '0', STR_PAD_LEFT);
        
        return $pdf->download("invoice-{$invoiceNumber}.pdf");
    }
}