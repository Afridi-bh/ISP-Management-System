@extends('customer.layout')

@section('title', 'Invoice Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        
        <!-- Header Actions -->
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('customer.payment.success') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
            <a href="{{ route('customer.payment.invoice.download', $invoice->id) }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download PDF
            </a>
        </div>

        <!-- Invoice Content -->
        <div class="bg-white rounded-lg shadow-xl p-8" id="invoice-content">
            
            <!-- Invoice Header -->
            <div class="border-b-4 border-blue-600 pb-6 mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-blue-600 mb-2">ISP Portal</h1>
                        <p class="text-gray-600">Internet Service Provider</p>
                        <p class="text-sm text-gray-500 mt-2">Email: support@ispportal.com</p>
                        <p class="text-sm text-gray-500">Phone: +880 1234-567890</p>
                    </div>
                    <div class="text-right">
                        <h2 class="text-4xl font-bold text-gray-800">INVOICE</h2>
                        <p class="text-lg text-gray-600 mt-2">#{{ $invoice->invoice_number }}</p>
                        <div class="mt-4">
                            <p class="text-sm"><strong>Date:</strong> {{ Carbon\Carbon::parse($invoice->issue_date)->format('M d, Y') }}</p>
                            <p class="text-sm"><strong>Due Date:</strong> {{ Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer & Status Info -->
            <div class="grid grid-cols-2 gap-6 mb-8">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">Bill To:</h3>
                    <p class="font-semibold text-gray-900">{{ $customer->name }}</p>
                    <p class="text-gray-600">{{ $customer->email }}</p>
                    <p class="text-gray-600">{{ $customer->phone }}</p>
                    <p class="text-xs text-gray-500 mt-2">Customer ID: #{{ $customer->id }}</p>
                </div>
                <div class="text-right">
                    <h3 class="text-lg font-bold text-gray-800 mb-3">Status:</h3>
                    @php
                        $statusColors = [
                            'paid' => 'bg-green-100 text-green-800 border-green-300',
                            'unpaid' => 'bg-red-100 text-red-800 border-red-300',
                            'partial' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                        ];
                        $statusClass = $statusColors[$invoice->status] ?? 'bg-gray-100 text-gray-800 border-gray-300';
                    @endphp
                    <span class="inline-block px-4 py-2 rounded-full font-bold border-2 {{ $statusClass }}">
                        {{ strtoupper($invoice->status) }}
                    </span>
                </div>
            </div>

            <!-- Invoice Items Table -->
            <table class="w-full mb-8">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Description</th>
                        <th class="text-center py-3 px-4 font-semibold text-gray-700">Period</th>
                        <th class="text-right py-3 px-4 font-semibold text-gray-700">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="py-4 px-4">
                            <p class="font-semibold text-gray-900">{{ $invoice->package_name }}</p>
                            <p class="text-sm text-gray-600">Monthly Subscription</p>
                        </td>
                        <td class="text-center py-4 px-4 text-gray-700">
                            {{ Carbon\Carbon::parse($invoice->issue_date)->format('M d') }} - 
                            {{ Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                        </td>
                        <td class="text-right py-4 px-4">
                            <p class="font-bold text-gray-900">৳{{ number_format($invoice->amount, 2) }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Totals -->
            <div class="flex justify-end mb-8">
                <div class="w-80">
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-semibold">৳{{ number_format($invoice->amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Tax (0%):</span>
                        <span class="font-semibold">৳0.00</span>
                    </div>
                    <div class="flex justify-between py-3 border-t-2 border-gray-800">
                        <span class="text-lg font-bold text-gray-800">Total:</span>
                        <span class="text-lg font-bold text-gray-900">৳{{ number_format($invoice->amount, 2) }}</span>
                    </div>
                    @if($invoice->status === 'paid')
                    <div class="flex justify-between py-2 bg-green-50 px-3 rounded mt-2">
                        <span class="text-green-700">Amount Paid:</span>
                        <span class="font-bold text-green-700">৳{{ number_format($invoice->paid_amount, 2) }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Payment Status Message -->
            @if($invoice->status === 'paid')
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-bold text-green-800">Payment Received</p>
                            <p class="text-sm text-green-700">This invoice has been paid in full. Thank you for your payment.</p>
                            @if($invoice->paid_date)
                                <p class="text-xs text-green-600 mt-1">Paid on: {{ Carbon\Carbon::parse($invoice->paid_date)->format('M d, Y') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-yellow-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-bold text-yellow-800">Payment Required</p>
                            <p class="text-sm text-yellow-700">Please make payment before {{ Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Footer -->
            <div class="border-t pt-6 text-sm text-gray-600">
                <p class="mb-2"><strong>Payment Methods:</strong> Bank Transfer, bKash, Nagad, Cash Payment</p>
                <p class="mb-2"><strong>Terms & Conditions:</strong> Payment is due within 30 days from the invoice date.</p>
                <p class="mb-4"><strong>Bank Details:</strong> Bank Name - Account Number: 1234567890</p>
                <p class="text-center text-gray-500 text-xs mt-6">
                    Thank you for your business! For any queries, contact us at support@ispportal.com
                </p>
            </div>
        </div>
    </div>
</div>
@endsection