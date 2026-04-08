<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\User;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        return view('billing.index');
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        // Get active users only
        $users = User::where('role', 'user')
            ->with('detail')
            ->whereHas('detail', function (Builder $query) {
                $query->where('status', 'active');
            })->orderBy('name')->get();

        return view('billing.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'checked' => 'required|array|min:1',
            'user_id' => 'required|array',
        ], [
            'checked.required' => 'Please select at least one user to generate bills.',
            'checked.min' => 'Please select at least one user to generate bills.',
        ]);

        try {
            $billsGenerated = 0;

            if (is_array($request->user_id) || is_object($request->user_id)) {
                foreach ($request->user_id as $key => $id) {
                    // Only process checked items
                    if (is_array($request->checked) && in_array($id, $request->checked, true)) {
                        // Generate bill for user
                        $user = User::with('detail')->find($id);
                        
                        if ($user && $user->detail) {
                            $billing = new Billing();
                            $billing->invoice = $billing->generateRandomNumber();
                            $billing->package_name = $user->detail->package_name;
                            $billing->package_price = $user->detail->package_price;
                            $billing->package_start = Carbon::now();
                            $billing->user_id = $user->id;
                            //$billing->customer_id = null;
                            $billing->save();
                            
                            // Update due amount in details
                            $user->detail->update([
                                'due' => $user->detail->due + $user->detail->package_price
                            ]);
                            
                            $billsGenerated++;
                        }
                    }
                }
            }

            if ($billsGenerated > 0) {
                return redirect('/admin/billing')->with('success', "Successfully generated {$billsGenerated} bill(s).");
            } else {
                return redirect('/admin/billing')->with('error', 'No bills were generated. Please try again.');
            }

        } catch (\Exception $e) {
            \Log::error('Billing Generation Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to generate bills: ' . $e->getMessage());
        }
    }
}