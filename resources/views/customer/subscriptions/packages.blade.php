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
                            <a href="{{ route('customer.package-requests.create') }}?package={{ $package->id }}" 
                               class="block w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white text-center py-3 rounded-lg font-semibold transition">
                                <i class="fas fa-paper-plane mr-2"></i> Request This Package
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection