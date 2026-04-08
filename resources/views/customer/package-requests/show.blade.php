@extends('layouts.customer')

@section('title', 'Package Request Details')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Package Request Details</h1>
                <p class="text-gray-600 mt-1">Request ID: #{{ $packageRequest->id }}</p>
            </div>
            <a href="{{ route('customer.package-requests.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to List
            </a>
        </div>

        <!-- Status Badge -->
        <div class="mb-6">
            @if($packageRequest->status === 'pending')
                <span class="px-4 py-2 inline-flex items-center text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                    <i class="fas fa-clock mr-2"></i> Pending Review
                </span>
            @elseif($packageRequest->status === 'approved')
                <span class="px-4 py-2 inline-flex items-center text-sm font-semibold rounded-full bg-green-100 text-green-800">
                    <i class="fas fa-check-circle mr-2"></i> Approved
                </span>
            @else
                <span class="px-4 py-2 inline-flex items-center text-sm font-semibold rounded-full bg-red-100 text-red-800">
                    <i class="fas fa-times-circle mr-2"></i> Rejected
                </span>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Package Information -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h3 class="font-semibold text-lg text-white flex items-center">
                        <i class="fas fa-box mr-2"></i> Requested Package
                    </h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Package Name</dt>
                            <dd class="text-lg font-semibold text-gray-900 mt-1">{{ $packageRequest->package->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Speed</dt>
                            <dd class="text-sm text-gray-900 mt-1">{{ $packageRequest->package->speed }} Mbps</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Monthly Price</dt>
                            <dd class="text-lg font-bold text-blue-600 mt-1">৳{{ number_format($packageRequest->package->price) }}</dd>
                        </div>
                        @if($packageRequest->package->description)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="text-sm text-gray-700 bg-gray-50 p-3 rounded mt-1">{{ $packageRequest->package->description }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Request Timeline -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                    <h3 class="font-semibold text-lg text-white flex items-center">
                        <i class="fas fa-history mr-2"></i> Request Timeline
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Requested -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-paper-plane text-blue-600"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Request Submitted</p>
                                <p class="text-xs text-gray-500">{{ $packageRequest->created_at->format('M d, Y H:i A') }}</p>
                                <p class="text-xs text-gray-400">{{ $packageRequest->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        @if($packageRequest->status === 'approved')
                            <!-- Approved -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-check text-green-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Request Approved</p>
                                    <p class="text-xs text-gray-500">{{ $packageRequest->approved_at->format('M d, Y H:i A') }}</p>
                                    @if($packageRequest->approvedBy)
                                        <p class="text-xs text-gray-400">by {{ $packageRequest->approvedBy->name }}</p>
                                    @endif
                                </div>
                            </div>
                        @elseif($packageRequest->status === 'rejected')
                            <!-- Rejected -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                                    <i class="fas fa-times text-red-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Request Rejected</p>
                                    <p class="text-xs text-gray-500">{{ $packageRequest->updated_at->format('M d, Y H:i A') }}</p>
                                    @if($packageRequest->approvedBy)
                                        <p class="text-xs text-gray-400">by {{ $packageRequest->approvedBy->name }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Your Notes -->
            @if($packageRequest->customer_notes)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <h3 class="font-semibold text-lg text-white flex items-center">
                        <i class="fas fa-sticky-note mr-2"></i> Your Notes
                    </h3>
                </div>
                <div class="p-6">
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <p class="text-sm text-gray-700 whitespace-pre-line">{{ $packageRequest->customer_notes }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Admin Response -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-6 py-4">
                    <h3 class="font-semibold text-lg text-white flex items-center">
                        <i class="fas fa-comment-alt mr-2"></i> Admin Response
                    </h3>
                </div>
                <div class="p-6">
                    @if($packageRequest->admin_remarks)
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $packageRequest->admin_remarks }}</p>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-hourglass-half text-gray-400 text-3xl mb-3"></i>
                            <p class="text-sm text-gray-500">Waiting for admin review...</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Action Message -->
        @if($packageRequest->status === 'pending')
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                    <div>
                        <h4 class="font-semibold text-blue-900">What happens next?</h4>
                        <p class="text-blue-700 text-sm mt-1">
                            Your request is currently under review. The admin will review your request and contact you shortly. 
                            You will receive a notification once your request is processed.
                        </p>
                    </div>
                </div>
            </div>
        @elseif($packageRequest->status === 'approved')
            <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                    <div>
                        <h4 class="font-semibold text-green-900">Request Approved!</h4>
                        <p class="text-green-700 text-sm mt-1">
                            Your package request has been approved. Our team will contact you soon for installation and payment details.
                            Check your subscription details for more information.
                        </p>
                        <a href="{{ route('customer.subscriptions') }}" 
                           class="inline-flex items-center mt-3 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm transition">
                            <i class="fas fa-th-list mr-2"></i> View Subscriptions
                        </a>
                    </div>
                </div>
            </div>
        @elseif($packageRequest->status === 'rejected')
            <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-times-circle text-red-600 mt-1 mr-3"></i>
                    <div>
                        <h4 class="font-semibold text-red-900">Request Rejected</h4>
                        <p class="text-red-700 text-sm mt-1">
                            Unfortunately, your package request was rejected. Please check the admin response above for the reason.
                            You can submit a new request if needed.
                        </p>
                        <a href="{{ route('customer.packages.index') }}" 
                           class="inline-flex items-center mt-3 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm transition">
                            <i class="fas fa-redo mr-2"></i> Browse Packages
                        </a>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection