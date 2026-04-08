@extends('layouts.customer')

@section('title', 'Request Package')

@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-8 text-white">
                <h1 class="text-3xl font-bold">Request Package</h1>
                <p class="text-blue-200 mt-2">Submit a request for package approval</p>
            </div>

            <div class="p-6">
                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-red-600 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-red-900">Error</h4>
                                <ul class="text-red-700 text-sm mt-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-semibold text-blue-900">How it works</h4>
                            <p class="text-blue-700 text-sm mt-1">
                                1. Submit your package request<br>
                                2. Admin will review and approve/reject<br>
                                3. You'll be notified once processed<br>
                                4. After approval, payment instructions will be provided
                            </p>
                        </div>
                    </div>
                </div>

                <div class="border rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Package Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Package Name</p>
                            <p class="font-semibold text-lg">{{ $package->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Speed</p>
                            <p class="font-semibold text-lg text-green-600">{{ $package->speed }} Mbps</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Monthly Price</p>
                            <p class="font-semibold text-lg text-blue-600">৳{{ number_format($package->price) }}</p>
                        </div>
                        @if($package->description)
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Description</p>
                            <p class="text-gray-700">{{ $package->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <form action="{{ route('customer.package-requests.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="package_id" value="{{ $package->id }}">

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Location & Contact Information <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            name="customer_notes" 
                            rows="5" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('customer_notes') border-red-500 @enderror"
                            placeholder="Please provide:&#10;- Your full address&#10;- Contact phone number&#10;- Best time to contact&#10;- Any special installation requirements"
                            required
                        >{{ old('customer_notes') }}</textarea>
                        @error('customer_notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            This information helps us process your request faster and contact you for installation.
                        </p>
                    </div>

                    <div class="flex items-center justify-between border-t pt-6">
                        <a href="{{ route('customer.packages.index') }}" 
                           class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-md hover:from-blue-700 hover:to-purple-700 transition focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection