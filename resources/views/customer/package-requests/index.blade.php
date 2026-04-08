@extends('layouts.customer')

@section('title', 'My Package Requests')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                    <div>
                        <h4 class="font-semibold text-green-900">Success</h4>
                        <p class="text-green-700 text-sm mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-circle text-red-600 mt-1 mr-3"></i>
                    <div>
                        <h4 class="font-semibold text-red-900">Error</h4>
                        <p class="text-red-700 text-sm mt-1">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Page Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Package Requests</h1>
                <p class="text-gray-600 mt-2">View and track your package subscription requests</p>
            </div>
            <a href="{{ route('customer.packages.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-md hover:from-blue-700 hover:to-purple-700 transition">
                <i class="fas fa-plus mr-2"></i> New Request
            </a>
        </div>

        @if($packageRequests->count() > 0)
            <!-- Requests Grid -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($packageRequests as $request)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <!-- Status Header -->
                        <div class="px-6 py-4 
                            {{ $request->status === 'pending' ? 'bg-yellow-500' : ($request->status === 'approved' ? 'bg-green-500' : 'bg-red-500') }}">
                            <div class="flex items-center justify-between">
                                <span class="text-white font-semibold text-sm uppercase flex items-center">
                                    @if($request->status === 'pending')
                                        <i class="fas fa-clock mr-2"></i> Pending
                                    @elseif($request->status === 'approved')
                                        <i class="fas fa-check-circle mr-2"></i> Approved
                                    @else
                                        <i class="fas fa-times-circle mr-2"></i> Rejected
                                    @endif
                                </span>
                                <span class="text-white text-xs">#{{ $request->id }}</span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $request->package->name }}</h3>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-tachometer-alt w-5 text-blue-600"></i>
                                    <span>{{ $request->package->speed }} Mbps</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-tag w-5 text-green-600"></i>
                                    <span class="font-semibold">৳{{ number_format($request->package->price) }}/month</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-calendar-alt w-5 text-gray-600"></i>
                                    <span>{{ $request->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>

                            <!-- Request Timeline -->
                            <div class="border-t pt-4">
                                <p class="text-xs text-gray-500 mb-2">Timeline:</p>
                                <div class="space-y-2">
                                    <div class="flex items-center text-xs">
                                        <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
                                        <span class="text-gray-600">Submitted {{ $request->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if($request->status === 'approved' && $request->approved_at)
                                        <div class="flex items-center text-xs">
                                            <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                                            <span class="text-gray-600">Approved {{ $request->approved_at->diffForHumans() }}</span>
                                        </div>
                                    @elseif($request->status === 'rejected')
                                        <div class="flex items-center text-xs">
                                            <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>
                                            <span class="text-gray-600">Rejected {{ $request->updated_at->diffForHumans() }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Button -->
                            <div class="mt-4">
                                <a href="{{ route('customer.package-requests.show', $request->id) }}" 
                                   class="block w-full text-center px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-md transition">
                                    <i class="fas fa-eye mr-2"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $packageRequests->links() }}
            </div>

        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-md p-12">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-4">
                        <i class="fas fa-inbox text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Package Requests Yet</h3>
                    <p class="text-gray-600 mb-6">You haven't submitted any package requests yet.</p>
                    <a href="{{ route('customer.packages.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-md hover:from-blue-700 hover:to-purple-700 transition">
                        <i class="fas fa-plus mr-2"></i> Browse Packages
                    </a>
                </div>
            </div>
        @endif

        <!-- Info Card -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-600 mt-1 mr-4"></i>
                <div>
                    <h4 class="font-semibold text-blue-900 mb-2">About Package Requests</h4>
                    <ul class="text-blue-700 text-sm space-y-1">
                        <li>• Submit a request for any package you're interested in</li>
                        <li>• Admin will review your request within 24-48 hours</li>
                        <li>• You'll receive notifications when your request is processed</li>
                        <li>• After approval, our team will contact you for installation</li>
                        <li>• You can only have one pending request at a time</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection