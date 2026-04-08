<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Customer;
use App\Models\User;
use App\Models\Detail;

class CustomerLoginController extends Controller
{
    /**
     * Show the customer login form.
     */
    public function show()
    {
        // Redirect if already logged in
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.dashboard');
        }
        
        return view('customer.auth.login');
    }

    /**
     * Handle customer login request.
     * Supports login from both Customer table and User table (ISP users)
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $email = $request->email;
        $password = $request->password;
        $remember = $request->boolean('remember');

        // OPTION 1: Try to login as Customer (from customers table)
        $customer = Customer::where('email', $email)->first();

        if ($customer) {
            // Check customer status
            if ($customer->status !== 'active') {
                return back()->withErrors([
                    'email' => 'Your account has been suspended. Please contact support.',
                ])->onlyInput('email');
            }

            // Verify password
            if (Hash::check($password, $customer->password)) {
                // Login successful
                Auth::guard('customer')->login($customer, $remember);
                $request->session()->regenerate();

                return redirect()->route('customer.dashboard')
                    ->with('success');
            }
        }

        // OPTION 2: Try to login as ISP User (from users table)
        $user = User::where('email', $email)->first();

        if ($user) {
            // Check if user has detail record (is an ISP customer)
            $detail = Detail::where('user_id', $user->id)->first();

            if (!$detail) {
                return back()->withErrors([
                    'email' => 'This account is not set up for customer portal access. Please contact support.',
                ])->onlyInput('email');
            }

            // Check if user is active
            if ($detail->status !== 'active') {
                return back()->withErrors([
                    'email' => 'Your service has been suspended. Please contact support.',
                ])->onlyInput('email');
            }

            // Verify password
            if (Hash::check($password, $user->password)) {
                // User exists but no customer record - create one automatically
                $customer = Customer::firstOrCreate(
                    ['email' => $user->email],
                    [
                        'name' => $user->name,
                        'phone' => $detail->phone ?? null,
                        'password' => $user->password, // Use same password hash
                        'status' => 'active',
                        'email_verified_at' => $user->email_verified_at,
                    ]
                );

                // Login with customer guard
                Auth::guard('customer')->login($customer, $remember);
                $request->session()->regenerate();

                return redirect()->route('customer.dashboard')
                    ->with('success', 'Welcome to Customer Portal, ' . $customer->name . '!');
            }
        }

        // Neither customer nor user found, or password incorrect
        return back()->withErrors([
            'email' => 'The provided credentials are incorrect or account does not exist.',
        ])->onlyInput('email');
    }

    /**
     * Handle customer logout.
     */
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login')
            ->with('success', 'You have been logged out successfully.');
    }
}