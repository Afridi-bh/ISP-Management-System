<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Detail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerRegisterController extends Controller
{
    public function show()
    {
        return view('customer.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:6|confirmed',
            'address' => 'nullable|string',
            'dob' => 'nullable|date',
        ]);

        // Create customer
        $customer = Customer::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'status' => 'active',
        ]);

        // ⭐ Create detail entry for customer
        if ($request->filled('address') || $request->filled('dob')) {
            Detail::create([
                'customer_id' => $customer->id,
                'address' => $validated['address'] ?? '',
                'phone' => $validated['phone'],
                'dob' => $validated['dob'] ?? Carbon::now(),
                'router_password' => '', // Will be set later
                'package_name' => 'None',
                'router_name' => 'None',
                'package_price' => 0,
                'due' => 0,
                'status' => 'pending',
                'package_start' => Carbon::now(),
            ]);
        }

        // Log the customer in
        auth('customer')->login($customer);

        return redirect()->route('customer.dashboard')
            ->with('success', );
    }
}