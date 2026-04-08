@extends('customer.layout')

@section('title', 'Confirm Payment')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('customer.payments.create') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
        </div>

        <!-- Page Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Confirm Payment</h1>
            <p class="text-gray-600">Review details and select payment method</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Invoice Details Card -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Invoice Details</h2>
                        <p class="text-sm text-gray-500">Payment for {{ $user->name }}</p>
                    </div>
                </div>

                <div class="space-y-3 border-t pt-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">User Name:</span>
                        <span class="font-semibold text-gray-800">{{ $user->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Invoice Number:</span>
                        <span class="font-semibold text-gray-800">#{{ $billing->invoice }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Package:</span>
                        <span class="font-semibold text-gray-800">{{ $billing->package_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Issue Date:</span>
                        <span class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($billing->created_at)->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t">
                        <span class="text-lg font-semibold text-gray-700">Total Amount:</span>
                        <span class="text-2xl font-bold text-blue-600">৳{{ number_format($billing->package_price, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Method Card -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Payment Method</h2>
                        <p class="text-sm text-gray-500">Choose how to pay</p>
                    </div>
                </div>

                <form action="{{ route('customer.payment.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="billing_id" value="{{ $billing->id }}">

                    <!-- Payment Method Selection -->
                    <div class="space-y-3 mb-6">
                        <!-- bKash -->
                        <label class="relative flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-pink-50 hover:border-pink-300 transition-all duration-200 payment-method-label">
                            <input type="radio" name="payment_method" value="bkash" class="payment-method-radio" required>
                            <div class="ml-3 flex-1 flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">bKash</p>
                                        <p class="text-xs text-gray-500">Instant mobile payment</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-pink-100 text-pink-700 text-xs font-semibold rounded-full">Recommended</span>
                            </div>
                        </label>

                        <!-- Cash -->
                        <label class="relative flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-green-50 hover:border-green-300 transition-all duration-200 payment-method-label">
                            <input type="radio" name="payment_method" value="cash" class="payment-method-radio">
                            <div class="ml-3 flex-1 flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Cash</p>
                                    <p class="text-xs text-gray-500">Pay at office</p>
                                </div>
                            </div>
                        </label>

                        <!-- Bank Transfer -->
                        <label class="relative flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition-all duration-200 payment-method-label">
                            <input type="radio" name="payment_method" value="bank" class="payment-method-radio">
                            <div class="ml-3 flex-1 flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Bank Transfer</p>
                                    <p class="text-xs text-gray-500">Direct deposit</p>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- Security Notice -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-blue-800 mb-1">Secure Transaction</p>
                                <p class="text-xs text-blue-700">Your payment will be recorded and visible to the admin immediately.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex gap-3">
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Confirm & Pay
                        </button>
                        <a href="{{ route('customer.payments.create') }}" 
                           class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-all duration-200">
                            Cancel
                        </a>
                    </div>
                </form>
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
                label.classList.remove('border-blue-500', 'bg-blue-50', 'border-pink-500', 'bg-pink-50', 'border-green-500', 'bg-green-50');
                label.classList.add('border-gray-200');
            });
            
            if (this.checked) {
                const value = this.value;
                labels[index].classList.remove('border-gray-200');
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