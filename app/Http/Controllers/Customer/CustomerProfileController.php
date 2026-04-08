<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerProfileController extends Controller
{
    /**
     * Display the customer's profile
     */
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        
        return view('customer.profile', compact('customer'));
    }

    /**
     * Update the customer's profile information
     */
    public function update(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:customers,email,' . $customer->id],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $customer->update($validated);

        return redirect()->route('customer.profile')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the customer's password
     */
    public function updatePassword(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password:customer'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $customer->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('customer.profile')
            ->with('success', 'Password updated successfully!');
    }

    /**
     * Update notification preferences
     */
    public function updateNotifications(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        // If you have a notifications preferences column
        // $customer->update([
        //     'email_notifications' => $request->boolean('email_notifications'),
        //     'sms_notifications' => $request->boolean('sms_notifications'),
        // ]);

        return redirect()->route('customer.profile')
            ->with('success', 'Notification preferences updated successfully!');
    }
}