<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerPackageRequestController extends Controller
{
    /**
     * Display package requests history
     */
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        $packageRequests = $customer->packageRequests()
            ->with('package')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.package-requests.index', compact('packageRequests'));
    }

    /**
     * Show form to request a package
     */
    public function create(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        
        // Check if already has pending request
        $hasPendingRequest = $customer->packageRequests()
            ->where('status', 'pending')
            ->exists();

        if ($hasPendingRequest) {
            return redirect()->route('customer.packages.index')
                ->with('error', 'You already have a pending package request. Please wait for approval.');
        }

        $packageId = $request->query('package');
        $package = Package::findOrFail($packageId);

        return view('customer.package-requests.create', compact('package'));
    }

    /**
     * Store new package request
     */
    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'customer_notes' => 'nullable|string|max:1000',
        ]);

        $customer = Auth::guard('customer')->user();

        // Check if already has pending request
        $hasPendingRequest = $customer->packageRequests()
            ->where('status', 'pending')
            ->exists();

        if ($hasPendingRequest) {
            return redirect()->route('customer.packages.index')
                ->with('error', 'You already have a pending package request.');
        }

        try {
            DB::beginTransaction();

            PackageRequest::create([
                'customer_id' => $customer->id,
                'package_id' => $request->package_id,
                'customer_notes' => $request->customer_notes, // Save customer notes
                'status' => 'pending',
            ]);

            DB::commit();

            return redirect()->route('customer.package-requests.index')
                ->with('success',);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Package request creation error: ' . $e->getMessage());
            return redirect()->route('customer.packages.index')
                ->with('error', 'Failed to submit package request. Please try again.');
        }
    }

    /**
     * Show package request details
     */
    public function show(PackageRequest $packageRequest)
    {
        // Check if the package request belongs to the authenticated customer
        if ($packageRequest->customer_id !== Auth::guard('customer')->id()) {
            abort(403, 'Unauthorized access to this package request.');
        }

        $packageRequest->load(['package', 'approvedBy']);

        return view('customer.package-requests.show', compact('packageRequest'));
    }
}