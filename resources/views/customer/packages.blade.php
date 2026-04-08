@extends('layouts.customer')

@section('title', 'Available Packages')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-box text-blue-600"></i> Available Packages
            </h1>
            <p class="text-gray-600 mt-1">Choose the perfect package for your needs</p>
        </div>

        @php
            $hasPendingRequest = auth()->guard('customer')->user()->packageRequests()
                ->where('status', 'pending')
                ->exists();
        @endphp

        @if($hasPendingRequest)
            <div class="mb-6 bg-yellow-50 border border-yellow-400 text-yellow-800 px-6 py-4 rounded-lg">
                <i class="fas fa-info-circle mr-2"></i>
                You already have a pending package request. Please wait for admin approval before submitting another request.
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($packages as $package)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-6 text-center">
                        <h3 class="text-2xl font-bold mb-2">{{ $package->name }}</h3>
                        <div class="text-4xl font-bold mb-1">৳{{ number_format($package->price) }}</div>
                        <p class="text-blue-100">per month</p>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 text-center mb-6 min-h-[60px]">
                            Perfect for {{ strtolower($package->name) }} internet usage
                        </p>
                        @if($hasPendingRequest)
                            <button disabled 
                                    class="w-full bg-gray-300 text-gray-500 py-3 rounded-lg font-semibold cursor-not-allowed">
                                <i class="fas fa-lock mr-2"></i> Request Pending
                            </button>
                        @else
                            <a href="{{ route('customer.package-requests.create', ['package' => $package->id]) }}" 
                               class="block w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white text-center py-3 rounded-lg font-semibold transition">
                                <i class="fas fa-paper-plane mr-2"></i> Request This Package
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Setup Information Note - Red Alert Style -->
        <div class="mt-8 bg-gradient-to-r from-red-50 to-orange-50 border-2 border-red-400 rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-red-500 to-orange-500 px-6 py-3">
                <h4 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-exclamation-triangle mr-3 text-2xl animate-pulse"></i>
                    Important Notice - Setup & Installation
                </h4>
            </div>
            <div class="p-6">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-tools text-red-600 text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-800 text-lg leading-relaxed mb-4">
                            <strong class="text-red-700">Please Note:</strong> The prices displayed above represent <span class="font-semibold text-red-600">monthly subscription fees only</span>. Additional charges apply for installation and setup.
                        </p>
                        <div class="bg-white rounded-lg p-4 border-l-4 border-red-500 shadow-sm">
                            <ul class="space-y-2 text-gray-700">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-red-500 mr-3 mt-1"></i>
                                    <span>Installation and setup charges will be discussed separately</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-red-500 mr-3 mt-1"></i>
                                    <span>Equipment costs (router, cables, etc.) will be finalized upon contact</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-red-500 mr-3 mt-1"></i>
                                    <span>Our team will provide detailed cost breakdown before installation</span>
                                </li>
                            </ul>
                        </div>
                        <p class="text-gray-700 mt-4 italic">
                            <i class="fas fa-phone-alt text-red-500 mr-2"></i>
                            A representative will contact you to discuss all one-time setup costs and answer any questions you may have.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection