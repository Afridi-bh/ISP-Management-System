@extends('customer.layout')

@section('title', 'Make Payment')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('customer.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('customer.invoices') }}" class="ml-1 text-gray-700 hover:text-blue-600">
                        Invoices
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-gray-500">Make Payment</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Payment Form Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Choose Payment Method</h2>

                <!-- Payment Method Selection -->
                <div class="space-y-4 mb-8">
                    <!-- bKash Payment -->
                    <div class="border-2 border-pink-500 rounded-lg p-6 bg-pink-50 hover:shadow-lg transition duration-200 cursor-pointer" onclick="selectPaymentMethod('bkash')">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="bg-pink-600 rounded-lg p-3">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">bKash Payment</h3>
                                    <p class="text-sm text-gray-600">Pay securely with bKash Mobile Banking</p>
                                    <div class="flex items-center space-x-2 mt-2">
                                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Instant</span>
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Most Popular</span>
                                    </div>
                                </div>
                            </div>
                            <input type="radio" name="payment_method" value="bkash" id="bkash" class="w-5 h-5 text-pink-600" checked>
                        </div>
                    </div>

                    <!-- Bank Transfer -->
                    <div class="border-2 border-gray-300 rounded-lg p-6 hover:border-blue-500 hover:shadow-lg transition duration-200 cursor-pointer" onclick="selectPaymentMethod('bank')">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="bg-blue-600 rounded-lg p-3">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">Bank Transfer</h3>
                                    <p class="text-sm text-gray-600">Direct bank deposit or online banking</p>
                                </div>
                            </div>
                            <input type="radio" name="payment_method" value="bank" id="bank" class="w-5 h-5 text-blue-600">
                        </div>
                    </div>

                    <!-- Cash Payment -->
                    <div class="border-2 border-gray-300 rounded-lg p-6 hover:border-green-500 hover:shadow-lg transition duration-200 cursor-pointer" onclick="selectPaymentMethod('cash')">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="bg-green-600 rounded-lg p-3">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">Cash Payment</h3>
                                    <p class="text-sm text-gray-600">Pay at our office location</p>
                                </div>
                            </div>
                            <input type="radio" name="payment_method" value="cash" id="cash" class="w-5 h-5 text-green-600">
                        </div>
                    </div>
                </div>

                <!-- bKash Instructions (shown by default) -->
                <div id="bkash-instructions" class="bg-pink-50 border border-pink-200 rounded-lg p-6 mb-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-pink-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        How to pay with bKash
                    </h4>
                    <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
                        <li>Click "Pay with bKash" button below</li>
                        <li>Enter your bKash account number (01XXXXXXXXX)</li>
                        <li>You will receive a push notification on your phone</li>
                        <li>Enter your bKash PIN to confirm payment</li>
                        <li>Payment will be processed instantly</li>
                    </ol>
                </div>

                <!-- Bank Instructions (hidden by default) -->
                <div id="bank-instructions" class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6 hidden">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Bank Payment Instructions
                    </h4>
                    <div class="space-y-4 text-sm text-gray-700">
                        <div>
                            <p class="font-semibold mb-2">Bank Details:</p>
                            <ul class="space-y-1 ml-4">
                                <li>Bank Name: <strong>Dutch Bangla Bank Limited</strong></li>
                                <li>Account Name: <strong>BetterNet ISP</strong></li>
                                <li>Account Number: <strong>1234567890123</strong></li>
                                <li>Branch: <strong>Dhanmondi, Dhaka</strong></li>
                                <li>Routing Number: <strong>090123456</strong></li>
                            </ul>
                        </div>
                        <p class="text-red-600 font-medium">⚠️ Important: Please use Invoice Number as reference when making payment</p>
                    </div>
                </div>

                <!-- Cash Instructions (hidden by default) -->
                <div id="cash-instructions" class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6 hidden">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Cash Payment Instructions
                    </h4>
                    <div class="space-y-4 text-sm text-gray-700">
                        <div>
                            <p class="font-semibold mb-2">Office Location:</p>
                            <ul class="space-y-1 ml-4">
                                <li>📍 House #12, Road #5, Dhanmondi, Dhaka-1205</li>
                                <li>🕒 Office Hours: 9:00 AM - 6:00 PM (Sat-Thu)</li>
                                <li>📞 Phone: +880 1712-345678</li>
                            </ul>
                        </div>
                        <p class="text-orange-600 font-medium">💡 Tip: Please bring a printed copy of the invoice</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-4">
                    <button type="button" id="bkash-button" onclick="proceedToBkash()" 
                            class="flex-1 bg-gradient-to-r from-pink-600 to-pink-700 text-white px-6 py-3 rounded-lg font-semibold hover:from-pink-700 hover:to-pink-800 transition duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Pay with bKash
                    </button>

                    <button type="button" id="bank-button" onclick="submitManualPayment('bank')" 
                            class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition duration-200 hidden">
                        Continue with Bank Transfer
                    </button>

                    <button type="button" id="cash-button" onclick="submitManualPayment('cash')" 
                            class="flex-1 bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-lg font-semibold hover:from-green-700 hover:to-green-800 transition duration-200 hidden">
                        Continue with Cash Payment
                    </button>
                </div>

                <div class="mt-4">
                    <a href="{{ route('customer.invoices') }}" class="text-gray-600 hover:text-gray-800 text-sm flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Invoices
                    </a>
                </div>
            </div>
        </div>

        <!-- Invoice Summary Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6 sticky top-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Invoice Summary</h3>
                
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Invoice Number:</span>
                        <span class="font-semibold text-gray-800">{{ $invoice->invoice ?? 'INV-' . str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Invoice Date:</span>
                        <span class="font-semibold text-gray-800">{{ $invoice->created_at->format('M d, Y') }}</span>
                    </div>
                    
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Due Date:</span>
                        <span class="font-semibold text-gray-800">{{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') : 'N/A' }}</span>
                    </div>
                    
                    @if($invoice->package)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Package:</span>
                        <span class="font-semibold text-gray-800">{{ $invoice->package->name ?? 'N/A' }}</span>
                    </div>
                    @endif

                    <div class="border-t pt-4">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-semibold text-gray-800">৳{{ number_format($invoice->amount ?? 0, 2) }}</span>
                        </div>
                        
                        @if(isset($invoice->discount) && $invoice->discount > 0)
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Discount:</span>
                            <span class="font-semibold text-green-600">-৳{{ number_format($invoice->discount, 2) }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <div class="border-t pt-4">
                        <div class="flex justify-between">
                            <span class="text-lg font-bold text-gray-800">Total Amount:</span>
                            <span class="text-2xl font-bold text-blue-600">৳{{ number_format($invoice->amount ?? 0, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="mb-4">
                    @if($invoice->status === 'paid')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                            ✓ Paid
                        </span>
                    @elseif($invoice->status === 'pending')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                            ⏱ Pending
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                            ⚠ Unpaid
                        </span>
                    @endif
                </div>

                <!-- Security Notice -->
                <div class="bg-gray-50 rounded-lg p-4 text-xs text-gray-600">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <div>
                            <p class="font-semibold text-gray-800 mb-1">Secure Payment</p>
                            <p>Your payment information is encrypted and secure. We never store your card or banking details.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Form for Manual Payment Submission -->
<form id="manual-payment-form" method="POST" action="{{ route('customer.payment.process') }}" style="display: none;">
    @csrf
    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
    <input type="hidden" name="amount" value="{{ $invoice->amount }}">
    <input type="hidden" name="payment_method" id="hidden-payment-method" value="bkash">
</form>

@endsection

@push('scripts')
<script>
    function selectPaymentMethod(method) {
        // Update radio buttons
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.checked = radio.value === method;
        });

        // Update border styles
        document.querySelectorAll('[onclick^="selectPaymentMethod"]').forEach(div => {
            div.classList.remove('border-pink-500', 'border-blue-500', 'border-green-500', 'bg-pink-50');
            div.classList.add('border-gray-300');
        });

        const selectedDiv = document.querySelector(`[onclick="selectPaymentMethod('${method}')"]`);
        selectedDiv.classList.remove('border-gray-300');
        
        if (method === 'bkash') {
            selectedDiv.classList.add('border-pink-500', 'bg-pink-50');
        } else if (method === 'bank') {
            selectedDiv.classList.add('border-blue-500');
        } else if (method === 'cash') {
            selectedDiv.classList.add('border-green-500');
        }

        // Show/hide instructions
        document.getElementById('bkash-instructions').classList.toggle('hidden', method !== 'bkash');
        document.getElementById('bank-instructions').classList.toggle('hidden', method !== 'bank');
        document.getElementById('cash-instructions').classList.toggle('hidden', method !== 'cash');

        // Show/hide buttons
        document.getElementById('bkash-button').classList.toggle('hidden', method !== 'bkash');
        document.getElementById('bank-button').classList.toggle('hidden', method !== 'bank');
        document.getElementById('cash-button').classList.toggle('hidden', method !== 'cash');
    }

    function proceedToBkash() {
        // Redirect to bKash payment gateway
        window.location.href = "{{ route('bkash-create-payment', $invoice->id) }}";
    }

    function submitManualPayment(method) {
        if (confirm(`Are you sure you want to proceed with ${method.toUpperCase()} payment?`)) {
            document.getElementById('hidden-payment-method').value = method;
            document.getElementById('manual-payment-form').submit();
        }
    }
</script>
@endpush