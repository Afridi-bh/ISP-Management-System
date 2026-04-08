@extends('customer.layout')

@section('title', 'My Subscription')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">My Subscription</h1>
        <p class="mt-2 text-sm text-gray-600">
            Manage your internet package and subscription details
        </p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Approved Request Alert --}}
    @if($approvedRequest)
    <div class="mb-6 bg-green-50 border border-green-400 text-green-800 px-6 py-4 rounded-lg shadow">
        <div class="flex items-start">
            <svg class="h-6 w-6 mr-4 mt-1 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <div class="flex-1">
                <h3 class="font-semibold text-lg mb-1">Package Request Approved ✓</h3>
                <p class="text-sm mb-2">
                    Your request for <strong>{{ $approvedRequest->package->name }}</strong> package has been approved!
                </p>
                @if($approvedRequest->admin_remarks)
                <div class="mt-2 p-3 bg-green-100 rounded border border-green-300">
                    <p class="text-sm font-semibold mb-1">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
                        </svg>
                        Admin Remarks:
                    </p>
                    <p class="text-sm italic">"{{ $approvedRequest->admin_remarks }}"</p>
                </div>
                @endif
                <div class="flex items-center gap-4 text-sm mt-3">
                    <span>
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Approved: {{ $approvedRequest->updated_at->format('M d, Y h:i A') }}
                    </span>
                    <a href="{{ route('customer.package-requests.index') }}" class="text-green-700 hover:text-green-900 font-semibold">
                        View Details →
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Rejected Request Alert --}}
    @if($rejectedRequest)
    <div class="mb-6 bg-red-50 border border-red-400 text-red-800 px-6 py-4 rounded-lg shadow">
        <div class="flex items-start">
            <svg class="h-6 w-6 mr-4 mt-1 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <div class="flex-1">
                <h3 class="font-semibold text-lg mb-1">Package Request Rejected ✗</h3>
                <p class="text-sm mb-2">
                    Your request for <strong>{{ $rejectedRequest->package->name }}</strong> package has been rejected.
                </p>
                @if($rejectedRequest->admin_remarks)
                <div class="mt-2 p-3 bg-red-100 rounded border border-red-300">
                    <p class="text-sm font-semibold mb-1">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
                        </svg>
                        Reason:
                    </p>
                    <p class="text-sm italic">"{{ $rejectedRequest->admin_remarks }}"</p>
                </div>
                @endif
                <div class="flex items-center gap-4 text-sm mt-3">
                    <span>
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Rejected: {{ $rejectedRequest->updated_at->format('M d, Y h:i A') }}
                    </span>
                    <a href="{{ route('customer.package-requests.index') }}" class="text-red-700 hover:text-red-900 font-semibold">
                        View Details →
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Pending Request Alert --}}
    @if($pendingRequest)
    <div class="mb-6 bg-yellow-50 border border-yellow-400 text-yellow-800 px-6 py-4 rounded-lg shadow">
        <div class="flex items-start">
            <svg class="h-6 w-6 mr-4 mt-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
            </svg>
            <div class="flex-1">
                <h3 class="font-semibold text-lg mb-1">Package Request Pending Approval ⏳</h3>
                <p class="text-sm mb-2">
                    You have requested <strong>{{ $pendingRequest->package->name }}</strong> package. 
                    Our admin team will review and approve your request soon.
                </p>
                <div class="flex items-center gap-4 text-sm">
                    <span>
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Requested: {{ $pendingRequest->created_at->format('M d, Y') }}
                    </span>
                    <a href="{{ route('customer.package-requests.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                        View Details →
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($detail && $detail->package_name)
        @php
            // Calculate days remaining (30 days from package_start)
            $packageStart = \Carbon\Carbon::parse($detail->package_start);
            $expiresAt = $packageStart->copy()->addDays(30);
            $daysRemaining = max(0, now()->diffInDays($expiresAt, false));
        @endphp

        <!-- Current Subscription Card -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
            <!-- Header with Status Badge -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-8 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold">{{ $detail->package_name ?? 'No Package' }}</h2>
                        <p class="text-4xl font-extrabold mt-3">
                            ৳{{ number_format($detail->package_price ?? 0) }}
                            <span class="text-lg font-normal text-blue-200">/month</span>
                        </p>
                    </div>
                    <div>
                        @if($detail->status == 'active')
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-500 text-white">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-red-500 text-white">
                                Inactive
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Subscription Details -->
            <div class="px-6 py-6 bg-gray-50 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Started Date -->
                    <div>
                        <p class="text-sm font-medium text-gray-500">Started On</p>
                        <p class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $packageStart->format('M d, Y') }}
                        </p>
                    </div>

                    <!-- Expiry Date -->
                    <div>
                        <p class="text-sm font-medium text-gray-500">Expires On</p>
                        <p class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $expiresAt->format('M d, Y') }}
                        </p>
                    </div>

                    <!-- Days Remaining -->
                    <div>
                        <p class="text-sm font-medium text-gray-500">Days Remaining</p>
                        <p class="mt-1 text-lg font-semibold 
                            @if($daysRemaining <= 7) text-red-600 
                            @elseif($daysRemaining <= 14) text-yellow-600 
                            @else text-green-600 @endif">
                            {{ $daysRemaining }} days
                        </p>
                    </div>
                </div>
            </div>

            <!-- Additional Details -->
            <div class="px-6 py-4 bg-white border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Router</p>
                        <p class="mt-1 text-base font-semibold text-gray-900">{{ $detail->router_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Current Due</p>
                        <p class="mt-1 text-base font-semibold {{ $detail->due > 0 ? 'text-red-600' : 'text-green-600' }}">
                            ৳{{ number_format($detail->due ?? 0) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Phone</p>
                        <p class="mt-1 text-base font-semibold text-gray-900">{{ $detail->phone ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-6 bg-white">
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('customer.packages.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                        </svg>
                        Change Package
                    </a>

                    @if($daysRemaining <= 7 || $detail->due > 0)
                    <a href="{{ route('customer.payments') }}" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Pay Now
                    </a>
                    @endif

                    <a href="{{ route('customer.subscription.history') }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        View History
                    </a>
                </div>
            </div>
        </div>

        <!-- Warning for Expiring Soon -->
        @if($daysRemaining <= 7 && $daysRemaining > 0)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <strong>Your subscription is expiring soon!</strong> Only {{ $daysRemaining }} days remaining. 
                        <a href="{{ route('customer.payments') }}" class="font-medium underline hover:text-yellow-600">Pay now</a> to avoid service interruption.
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Due Payment Warning -->
        @if($detail->due > 0)
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">
                        <strong>You have an outstanding balance of ৳{{ number_format($detail->due) }}!</strong> 
                        <a href="{{ route('customer.payments') }}" class="font-medium underline hover:text-red-600">Pay now</a> to avoid service suspension.
                    </p>
                </div>
            </div>
        </div>
        @endif

    @else
         <!-- No Subscription -->
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No active subscription</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by subscribing to a package.</p>
            <div class="mt-6">
                <a href="{{ route('customer.packages.index') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    View Available Packages
                </a>
            </div>
        </div>
    @endif
</div>
@endsection