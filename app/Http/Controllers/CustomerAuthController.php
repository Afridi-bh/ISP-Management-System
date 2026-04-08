<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    /* Show customer login page */
    public function loginForm()
    {
        return view('customer.auth.login');
    }

    /* Handle customer login */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // login only if role = customer
        if (Auth::guard('web')->attempt([
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'customer'
        ], $request->remember)) {
            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid customer credentials']);
    }

    /* Show registration form */
    public function registerForm()
    {
        return view('customer.auth.register');
    }

    /* Handle customer registration */
    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:customers,email',
            'phone'                 => 'required|string|max:20',
            'password'              => 'required|min:6|confirmed',
        ]);

        $customer = Customer::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'customer',
        ]);

        Auth::login($customer);

        return redirect()->route('customer.dashboard');
    }

    /* Customer Logout */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('customer.login');
    }
}
