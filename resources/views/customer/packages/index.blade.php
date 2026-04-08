@extends('customer.layout')

@section('title', 'My Subscription')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">My Subscription</h1>
        <p class="mt-2 text-sm text-gray-600">
            Manage your internet package and subscription details
        </p>
    </div>

    {{-- Pending Request Alert --}}
    @if($pendingRequest)
    <div class="mb-6 bg-yellow-50 border border-yellow-400 text-yellow-800 px-6 py-4 rounded-lg shadow">
        <div class="flex items-start">
            <svg class="h-6 w-6 mr-4 mt-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
            </svg>
            <div class="flex-1">
                <h3 class="font-semibold text-lg mb-1">Package Request Pending Approval</h3>
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
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        View Details →
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($currentSubscription)
        <!-- Current Subscription Card -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
            <!-- Header with Status Badge -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-8 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold">{{ $currentSubscription->package->name }}</h2>
                        <p class="text-4xl font-extrabold mt-3">
                            ৳{{ number_format($currentSubscription->package->price) }}
                            <span class="text-lg font-normal text-blue-200">/month</span>
                        </p>
                    </div>
                    <div>
                        @if($currentSubscription->status == 'active')
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-500 text-white">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Active
                            </span>
                        @elseif($currentSubscription->status == 'pending')
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-yellow-500 text-white">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                Pending
                            </span>
                        @elseif($currentSubscription->status == 'expired')
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-red-500 text-white">
                                Expired
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
                            {{ $currentSubscription->started_at ? $currentSubscription->started_at->format('M d, Y') : 'N/A' }}
                        </p>
                    </div>

                    <!-- Expiry Date -->
                    <div>
                        <p class="text-sm font-medium text-gray-500">Expires On</p>
                        <p class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $currentSubscription->expires_at ? $currentSubscription->expires_at->format('M d, Y') : 'N/A' }}
                        </p>
                    </div>

                    <!-- Days Remaining -->
                    <div>
                        <p class="text-sm font-medium text-gray-500">Days Remaining</p>
                        <p class="mt-1 text-lg font-semibold 
                            @if($currentSubscription->daysRemaining() <= 7) text-red-600 
                            @elseif($currentSubscription->daysRemaining() <= 14) text-yellow-600 
                            @else text-green-600 @endif">
                            {{ $currentSubscription->daysRemaining() }} days
                        </p>
                    </div>
                </div>
            </div>

            <!-- Auto Renewal Status -->
            <div class="px-6 py-4 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">Auto-Renewal</h3>
                        <p class="text-sm text-gray-500">
                            Automatically renew your subscription each month
                        </p>
                    </div>
                    <form method="POST" action="{{ route('customer.subscription.auto-renew') }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                @if($currentSubscription->auto_renew) bg-blue-600 @else bg-gray-200 @endif">
                            <span class="translate-x-0 inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out
                                @if($currentSubscription->auto_renew) translate-x-5 @else translate-x-0 @endif">
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-6 bg-white">
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('customer.packages.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                        </svg>
                        Upgrade Package
                    </a>

                    @if($currentSubscription->status == 'expired' || $currentSubscription->daysRemaining() <= 7)
                    <form method="POST" action="{{ route('customer.subscription.renew') }}" class="inline-block">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Renew Now
                        </button>
                    </form>
                    @endif

                    <a href="{{ route('customer.subscription.history') }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        View History
                    </a>
                </div>
            </div>
        </div>

        <!-- Warning for Expiring Soon -->
        @if($currentSubscription->daysRemaining() <= 7 && $currentSubscription->daysRemaining() > 0)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <strong>Your subscription is expiring soon!</strong> Only {{ $currentSubscription->daysRemaining() }} days remaining. 
                        <a href="{{ route('customer.subscription.renew') }}" class="font-medium underline hover:text-yellow-600">Renew now</a> to avoid service interruption.
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