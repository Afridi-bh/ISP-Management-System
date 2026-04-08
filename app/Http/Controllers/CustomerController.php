<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display the specified customer
     */
    public function show(Customer $customer)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $customer->load(['detail', 'packageRequests', 'invoices', 'payments']);
        
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified customer
     */
    public function edit(Customer $customer)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        // Ensure customer has detail record
        if (!$customer->detail) {
            Detail::create([
                'customer_id' => $customer->id,
                'user_id' => null,
                'address' => '',
                'phone' => $customer->phone ?? '',
                'dob' => now()->subYears(18),
                'router_password' => '',
                'package_name' => 'None',
                'router_name' => 'None',
                'package_price' => 0,
                'due' => 0,
                'status' => 'inactive',
                'package_start' => now(),
            ]);
            $customer->refresh();
        }

        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer
     */
    public function update(Request $request, Customer $customer)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'required|string',
            'password' => 'nullable|min:6|confirmed',
            'address' => 'required|string',
            'dob' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            // Update customer
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            
            if ($request->filled('password')) {
                $customer->password = Hash::make($request->password);
            }
            
            $customer->save();

            // Update customer details
            if ($customer->detail) {
                $customer->detail->update([
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'dob' => $request->dob,
                    'pin' => $request->pin,
                ]);
            }

            DB::commit();
            return redirect()->route('customers.show', $customer)->with('success', 'Customer updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update customer: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Disable customer account
     */
    public function disable(Customer $customer)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        try {
            DB::beginTransaction();

            $customer->update(['status' => 'suspended']);
            
            if ($customer->detail) {
                $customer->detail->update(['status' => 'inactive']);
            }

            DB::commit();
            return back()->with('success', 'Customer account suspended');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to suspend customer: ' . $e->getMessage());
        }
    }

    /**
     * Enable customer account
     */
    public function enable(Customer $customer)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        try {
            DB::beginTransaction();

            $customer->update(['status' => 'active']);
            
            if ($customer->detail) {
                $customer->detail->update(['status' => 'active']);
            }

            DB::commit();
            return back()->with('success', 'Customer account activated');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to activate customer: ' . $e->getMessage());
        }
    }
}