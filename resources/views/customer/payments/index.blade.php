@extends('customer.layout')

@section('title', 'Payment Portal')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Payment Portal</h1>
            <p class="text-gray-600 text-lg">Enter user credentials to view package details and make payment</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(!isset($userDetail))
        <!-- Credential Input Form -->
        <div class="bg-white rounded-xl shadow-2xl p-8 max-w-2xl mx-auto">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Verify User Credentials</h2>
                <p class="text-gray-600">Enter mobile number and PIN to view package details</p>
            </div>

            <form action="{{ route('customer.payment.verify') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Mobile Number Field -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Mobile Number
                    </label>
                    <input type="text" 
                           name="phone" 
                           id="phone" 
                           class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                           placeholder="e.g., 01712345678"
                           value="{{ old('phone') }}"
                           required>
                    <p class="text-xs text-gray-500 mt-2">Enter the registered mobile number</p>
                </div>

                <!-- PIN Field -->
                <div>
                    <label for="pin" class="block text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        Security PIN
                    </label>
                    <input type="password" 
                           name="pin" 
                           id="pin" 
                           class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                           placeholder="Enter 4-6 digit PIN"
                           maxlength="6"
                           required>
                    <p class="text-xs text-gray-500 mt-2">Enter the security PIN</p>
                </div>

                <!-- Security Notice -->
                <div class="bg-blue-50 border-l-4 border-blue-500 rounded p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-semibold mb-1">🔒 Secure Payment Portal</p>
                            <ul class="space-y-1 text-xs">
                                <li>• Your information is encrypted and secure</li>
                                <li>• You'll see current package details after verification</li>
                                <li>• Pay only for the current month's bill</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center text-lg">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Verify & View Package
                </button>
            </form>
        </div>

        @else
        <!-- User Package Details & Payment -->
        <div class="space-y-6">
            <!-- User Information Card -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-2xl p-8 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-6">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold mb-2">{{ $user->name }}</h2>
                            <p class="text-blue-100 text-lg">{{ $userDetail->phone }}</p>
                            <p class="text-blue-100 text-sm">{{ $user->email }}</p>
                        </div>
                    </div>
                    <a href="{{ route('customer.payments') }}" 
                       class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition-all">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Clear
                    </a>
                </div>
            </div>

            <!-- Package Details Card -->
            <div class="bg-white rounded-xl shadow-xl p-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-7 h-7 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Current Package Details
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Package Info -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <span class="text-gray-600 font-medium">Package Name:</span>
                            <span class="text-lg font-bold text-gray-900">{{ $userDetail->package_name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <span class="text-gray-600 font-medium">Monthly Price:</span>
                            <span class="text-lg font-bold text-gray-900">৳{{ number_format($userDetail->package_price ?? 0, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <span class="text-gray-600 font-medium">Router:</span>
                            <span class="text-lg font-bold text-gray-900">{{ $userDetail->router_name ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <!-- Status & Due -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <span class="text-gray-600 font-medium">Package Start:</span>
                            <span class="text-lg font-bold text-gray-900">{{ \Carbon\Carbon::parse($userDetail->package_start)->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <span class="text-gray-600 font-medium">Status:</span>
                            @if($userDetail->status === 'active')
                                <span class="px-4 py-2 bg-green-100 text-green-800 text-sm font-bold rounded-full">Active</span>
                            @else
                                <span class="px-4 py-2 bg-red-100 text-red-800 text-sm font-bold rounded-full">Inactive</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border-2 border-red-200">
                            <span class="text-red-700 font-bold">Total Due:</span>
                            <span class="text-2xl font-bold text-red-600">৳{{ number_format($userDetail->due ?? 0, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Month Bill -->
            @if($currentBilling)
            <div class="bg-white rounded-xl shadow-xl p-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-7 h-7 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Current Month Invoice
                </h3>

                <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-lg p-6 border-2 border-green-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Invoice Number</p>
                            <p class="text-lg font-bold text-gray-900">#{{ $currentBilling->invoice }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Issue Date</p>
                            <p class="text-lg font-bold text-gray-900">{{ \Carbon\Carbon::parse($currentBilling->created_at)->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Amount Due</p>
                            <p class="text-2xl font-bold text-green-600">৳{{ number_format($currentBilling->package_price, 2) }}</p>
                        </div>
                    </div>

                    <!-- Payment Method Selection -->
                    <form action="{{ route('customer.payment.process') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="billing_id" value="{{ $currentBilling->id }}">

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Select Payment Method</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- bKash -->
                                <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-pink-500 hover:bg-pink-50 transition-all payment-method-label">
                                    <input type="radio" name="payment_method" value="bkash" class="payment-method-radio" required>
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center mb-1">
                                            <div class="w-8 h-8 bg-pink-100 rounded-full flex items-center justify-center mr-2">
                                                <svg class="w-4 h-4 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                                                </svg>
                                            </div>
                                            <strong class="text-gray-800">bKash</strong>
                                        </div>
                                        <p class="text-xs text-gray-500">Mobile payment</p>
                                    </div>
                                </label>

                                <!-- Cash -->
                                <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-green-500 hover:bg-green-50 transition-all payment-method-label">
                                    <input type="radio" name="payment_method" value="cash" class="payment-method-radio">
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center mb-1">
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-2">
                                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <strong class="text-gray-800">Cash</strong>
                                        </div>
                                        <p class="text-xs text-gray-500">Pay at office</p>
                                    </div>
                                </label>

                                <!-- Bank -->
                                <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all payment-method-label">
                                    <input type="radio" name="payment_method" value="bank" class="payment-method-radio">
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center mb-1">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-2">
                                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <strong class="text-gray-800">Bank</strong>
                                        </div>
                                        <p class="text-xs text-gray-500">Bank transfer</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Pay Button -->
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center text-lg">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Pay ৳{{ number_format($currentBilling->package_price, 2) }} Now
                        </button>
                    </form>
                </div>
            </div>
            @else
            <div class="bg-white rounded-xl shadow-xl p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">No Pending Invoice</h3>
                <p class="text-gray-600">This user has no unpaid invoices for the current month.</p>
            </div>
            @endif
        </div>
        @endif

        <!-- Help Section -->
        <div class="mt-8 bg-gradient-to-r from-gray-50 to-blue-50 border border-gray-200 rounded-xl p-6">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Need Help?</h3>
                    <p class="text-sm text-gray-600 mb-3">For any payment-related queries or technical support, please contact our customer service team.</p>
                    <a href="{{ route('customer.support') }}" 
                       class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Contact Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const radioButtons = document.querySelectorAll('.payment-method-radio');
    const labels = document.querySelectorAll('.payment-method-label');
    
    radioButtons.forEach((radio, index) => {
        radio.addEventListener('change', function() {
            labels.forEach(label => {
                label.classList.remove('border-pink-500', 'bg-pink-50', 'border-green-500', 'bg-green-50', 'border-blue-500', 'bg-blue-50');
                label.classList.add('border-gray-300');
            });
            
            if (this.checked) {
                const value = this.value;
                labels[index].classList.remove('border-gray-300');
                if (value === 'bkash') {
                    labels[index].classList.add('border-pink-500', 'bg-pink-50');
                } else if (value === 'cash') {
                    labels[index].classList.add('border-green-500', 'bg-green-50');
                } else {
                    labels[index].classList.add('border-blue-500', 'bg-blue-50');
                }
            }
        });
    });
});
</script>
@endsection