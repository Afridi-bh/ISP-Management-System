@extends('customer.layout')

@section('title', 'My Subscription')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">My Subscription</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    @php
        $detail = $customer->details ?? null;
    @endphp

    @if($detail)
        @php
            $daysLeft = 0;
            if ($detail->package_start) {
                try {
                    $daysLeft = now()->diffInDays(\Carbon\Carbon::parse($detail->package_start)->addDays(30), false);
                } catch (\Exception $e) {
                    $daysLeft = 0;
                }
            }
        @endphp

        <!-- Expiry Warning -->
        @if($daysLeft <= 7 && $daysLeft > 0)
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded mb-4 flex items-center">
                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <strong>⚠️ Subscription Expiring Soon!</strong> Your subscription will expire in <strong>{{ $daysLeft }} days</strong>.
                    <a href="{{ route('customer.invoices') }}" class="underline font-semibold ml-2">Pay Now →</a>
                </div>
            </div>
        @elseif($daysLeft <= 0)
            <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-4 flex items-center">
                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <strong>❌ Subscription Expired!</strong> Your subscription has expired. Please renew to continue service.
                    <a href="{{ route('customer.invoices') }}" class="underline font-semibold ml-2">Renew Now →</a>
                </div>
            </div>
        @endif

        <!-- Current Subscription Card -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow-lg text-white p-8 mb-6">
            <div class="flex justify-between items-start flex-wrap">
                <div>
                    <h2 class="text-2xl font-bold mb-2">{{ $detail->package_name ?? 'N/A' }}</h2>
                    <p class="text-blue-100">Active Subscription</p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold">৳{{ number_format($detail->package_price ?? 0, 2) }}</div>
                    <p class="text-blue-100">per month</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
                <div class="bg-white bg-opacity-20 rounded-lg p-4">
                    <div class="text-sm text-blue-100 mb-1">Start Date</div>
                    <div class="text-lg font-semibold">
                        @if($detail->package_start)
                            {{ \Carbon\Carbon::parse($detail->package_start)->format('M d, Y') }}
                        @else
                            N/A
                        @endif
                    </div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-lg p-4">
                    <div class="text-sm text-blue-100 mb-1">Days Remaining</div>
                    <div class="text-lg font-semibold {{ $daysLeft <= 7 ? 'text-yellow-300' : '' }}">
                        {{ max(0, (int)$daysLeft) }} days
                    </div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-lg p-4">
                    <div class="text-sm text-blue-100 mb-1">Status</div>
                    <div class="text-lg font-semibold">
                        @if(($detail->status ?? '') === 'active')
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Active
                            </span>
                        @else
                            {{ ucfirst($detail->status ?? 'N/A') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscription Details -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Package Information -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Package Information</h3>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Package Name:</span>
                        <span class="font-semibold text-gray-800">{{ $detail->package_name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Monthly Fee:</span>
                        <span class="font-semibold text-gray-800">৳{{ number_format($detail->package_price ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Router:</span>
                        <span class="font-semibold text-gray-800">{{ $detail->router_name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-600">Connection Status:</span>
                        <span class="font-semibold {{ ($detail->status ?? '') === 'active' ? 'text-green-600' : 'text-red-600' }}">
                            {{ ucfirst($detail->status ?? 'Inactive') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Billing Information -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Billing Information</h3>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Current Due:</span>
                        <span class="font-bold text-lg {{ ($detail->due ?? 0) > 0 ? 'text-red-600' : 'text-green-600' }}">
                            ৳{{ number_format($detail->due ?? 0, 2) }}
                        </span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Next Billing Date:</span>
                        <span class="font-semibold text-gray-800">
                            @if($detail->package_start)
                                {{ \Carbon\Carbon::parse($detail->package_start)->addDays(30)->format('M d, Y') }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-600">Payment Method:</span>
                        <span class="font-semibold text-gray-800">Multiple Options</span>
                    </div>
                </div>

                @if(($detail->due ?? 0) > 0)
                    <div class="mt-6 pt-4 border-t">
                        <a href="{{ route('customer.invoices') }}" 
                           class="block w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white text-center py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Pay Outstanding Balance Now
                        </a>
                    </div>
                @else
                    <div class="mt-6 pt-4 border-t">
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                            <svg class="w-8 h-8 text-green-600 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-green-800 font-semibold">All Paid Up! 🎉</p>
                            <p class="text-green-600 text-sm mt-1">You have no outstanding balance</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-semibold mb-6 text-gray-800">Quick Actions</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('customer.invoices') }}" 
                   class="bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 border border-blue-200 text-center py-6 rounded-lg transition-all duration-200 group">
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="text-sm font-semibold text-gray-800">View Invoices</div>
                </a>

                <a href="{{ route('customer.payments') }}" 
                   class="bg-gradient-to-br from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 border border-green-200 text-center py-6 rounded-lg transition-all duration-200 group">
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="text-sm font-semibold text-gray-800">Payment History</div>
                </a>

                <a href="{{ route('customer.support') }}" 
                   class="bg-gradient-to-br from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 border border-purple-200 text-center py-6 rounded-lg transition-all duration-200 group">
                    <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div class="text-sm font-semibold text-gray-800">Get Support</div>
                </a>

                <a href="{{ route('customer.packages.index') }}" 
                   class="bg-gradient-to-br from-orange-50 to-orange-100 hover:from-orange-100 hover:to-orange-200 border border-orange-200 text-center py-6 rounded-lg transition-all duration-200 group">
                    <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <div class="text-sm font-semibold text-gray-800">Upgrade Plan</div>
                </a>
            </div>
        </div>

    @else
        <!-- No Subscription -->
        <div class="bg-white rounded-lg shadow-lg p-12 text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
            </div>
            <h2 class="text-2xl font-semibold mb-3 text-gray-800">No Active Subscription</h2>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">You don't have an active subscription. Choose a package to get started and enjoy high-speed internet!</p>
            <a href="{{ route('customer.packages.index') }}" 
               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Browse Available Packages
            </a>
        </div>
    @endif
</div>
@endsection