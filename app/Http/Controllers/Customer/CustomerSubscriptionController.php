<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Detail;
use App\Models\User;
use App\Models\PackageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerSubscriptionController extends Controller
{
    /**
     * Display customer's subscription based on their linked user account
     */
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        
        // Find the user account linked to this customer (by email or phone)
        $user = User::where('email', $customer->email)
            ->orWhere(function($query) use ($customer) {
                $query->whereHas('detail', function($q) use ($customer) {
                    $q->where('phone', $customer->phone);
                });
            })
            ->first();
        
        // Get the detail for this user
        $detail = null;
        if ($user) {
            $detail = Detail::where('user_id', $user->id)->first();
        }

        // Get ONLY pending package requests
        $pendingRequest = PackageRequest::where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->with('package')
            ->first();

        // Get recently approved package requests (last 7 days)
        $approvedRequest = PackageRequest::where('customer_id', $customer->id)
            ->where('status', 'approved')
            ->where('updated_at', '>=', now()->subDays(7))
            ->with('package')
            ->orderBy('updated_at', 'desc')
            ->first();

        // Get recently rejected package requests (last 7 days)
        $rejectedRequest = PackageRequest::where('customer_id', $customer->id)
            ->where('status', 'rejected')
            ->where('updated_at', '>=', now()->subDays(7))
            ->with('package')
            ->orderBy('updated_at', 'desc')
            ->first();

        return view('customer.subscriptions.index', compact(
            'customer',
            'detail',
            'user',
            'pendingRequest',
            'approvedRequest',
            'rejectedRequest'
        ));
    }

    /**
     * Display all available packages
     */
    public function packages()
    {
        $customer = Auth::guard('customer')->user();
        $packages = Package::orderBy('price', 'asc')->get();

        return view('customer.packages', compact('packages', 'customer'));
    }

    /**
     * Subscription history
     */
    public function history()
    {
        $customer = Auth::guard('customer')->user();
        
        // Find linked user
        $user = User::where('email', $customer->email)->first();
        
        if (!$user) {
            return redirect()->route('customer.subscriptions')
                ->with('error', 'No user account found.');
        }
        
        // Get billing history for this user
        $subscriptionHistory = \App\Models\Billing::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.subscriptions.history', compact('subscriptionHistory'));
    }
}