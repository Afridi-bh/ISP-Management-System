<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageRequest;
use Illuminate\Http\Request;

class CustomerPackageRequestController extends Controller
{
    /**
     * Show all packages available for request
     */
    public function packages()
    {
        $packages = Package::orderBy('price')->get();
        $customer = auth('customer')->user();
        $hasPendingRequest = $customer->hasPendingRequest();

        return view('customer.packages', compact('packages', 'hasPendingRequest'));
    }

    /**
     * Display customer's package requests
     */
    public function index()
    {
        $customer = auth('customer')->user();
        $requests = $customer->packageRequests()->with('package')->latest()->get();

        return view('customer.package-requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new package request
     */
    public function create(Request $request)
    {
        $customer = auth('customer')->user();

        // Check if customer has pending request
        if ($customer->hasPendingRequest()) {
            return redirect()->route('customer.package-requests.index')
                ->with('error', 'You already have a pending package request.');
        }

        $packages = Package::orderBy('price')->get();
        $selectedPackageId = $request->query('package');

        return view('customer.package-requests.create', compact('packages', 'selectedPackageId'));
    }

    /**
     * Store a newly created package request
     */
    public function store(Request $request)
    {
        $customer = auth('customer')->user();

        // Check if customer has pending request
        if ($customer->hasPendingRequest()) {
            return redirect()->route('customer.package-requests.index')
                ->with('error', 'You already have a pending package request.');
        }

        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'customer_notes' => 'required|string|min:10|max:1000',
        ]);

        try {
            PackageRequest::create([
                'customer_id' => $customer->id,
                'package_id' => $validated['package_id'],
                'customer_notes' => $validated['customer_notes'],
                'status' => 'pending',
            ]);

            return redirect()->route('customer.subscriptions')
                ->with('success', 'Package request submitted successfully! Please wait for admin approval.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to submit package request. Please try again.');
        }
    }

    /**
     * Display the specified package request
     */
    public function show(PackageRequest $packageRequest)
    {
        $customer = auth('customer')->user();

        // Ensure customer can only view their own requests
        if ($packageRequest->customer_id !== $customer->id) {
            abort(403, 'Unauthorized action.');
        }

        $packageRequest->load(['package', 'approvedBy']);

        return view('customer.package-requests.show', compact('packageRequest'));
    }
}