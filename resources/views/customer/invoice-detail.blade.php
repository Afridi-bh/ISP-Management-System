@extends('layouts.customer')

@section('title', 'Invoice Details')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Invoice Details</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Invoice #{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}
                </p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('customer.invoices.download', $invoice->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                    <i class="fas fa-download mr-2"></i> Download PDF
                </a>
                <a href="{{ route('customer.invoices') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>
        </div>

        <!-- Invoice Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg" id="invoice-content">
            
            <!-- Invoice Header -->
            <div class="p-8 border-b-2 border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-3xl font-bold text-blue-600 mb-2">
                            <i class="fas fa-wifi mr-2"></i>BetterNet ISP
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400">Internet Service Provider</p>
                        <div class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                            <p><i class="fas fa-envelope mr-2"></i>support@betternet.com</p>
                            <p><i class="fas fa-phone mr-2"></i>+880 1234-567890</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">INVOICE</p>
                        <p class="text-xl text-gray-600 dark:text-gray-400 mt-1">
                            #{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}
                        </p>
                        <div class="mt-4 text-sm">
                            <p class="text-gray-600 dark:text-gray-400">
                                <span class="font-semibold">Invoice Date:</span>
                                {{ \Carbon\Carbon::parse($invoice->billing_date)->format('M d, Y') }}
                            </p>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">
                                <span class="font-semibold">Due Date:</span>
                                <span class="{{ \Carbon\Carbon::parse($invoice->due_date)->isPast() && $invoice->status != 'paid' ? 'text-red-600 font-bold' : '' }}">
                                    {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer & Invoice Info -->
            <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Bill To -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                            <i class="fas fa-user mr-2 text-blue-600"></i>Bill To:
                        </h3>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <p class="font-semibold text-gray-900 dark:text-white text-lg">
                                {{ $customer->name }}
                            </p>
                            <p class="text-gray-600 dark:text-gray-400 mt-2">
                                <i class="fas fa-envelope mr-2"></i>{{ $customer->email }}
                            </p>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">
                                <i class="fas fa-phone mr-2"></i>{{ $customer->phone ?? 'N/A' }}
                            </p>
                            @if($detail && $detail->address)
                                <p class="text-gray-600 dark:text-gray-400 mt-1">
                                    <i class="fas fa-map-marker-alt mr-2"></i>{{ $detail->address }}
                                </p>
                            @endif
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">
                                Customer ID: #{{ str_pad($customer->id, 5, '0', STR_PAD_LEFT) }}
                            </p>
                        </div>
                    </div>

                    <!-- Invoice Details -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                            <i class="fas fa-file-invoice mr-2 text-blue-600"></i>Invoice Details:
                        </h3>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 space-y-3">
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Invoice Date:</span>
                                <span class="text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($invoice->billing_date)->format('M d, Y') }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Due Date:</span>
                                <span class="{{ \Carbon\Carbon::parse($invoice->due_date)->isPast() && $invoice->status != 'paid' ? 'text-red-600 font-bold' : 'text-gray-900 dark:text-white' }}">
                                    {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Billing Period:</span>
                                <span class="text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($invoice->billing_date)->format('M d') }} - 
                                    {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                                </span>
                            </div>
                            <div class="flex justify-between pt-3 border-t border-gray-300 dark:border-gray-600">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Status:</span>
                                <span>
                                    @php
                                        $statusConfig = [
                                            'paid' => ['bg' => 'bg-green-100 dark:bg-green-900', 'text' => 'text-green-800 dark:text-green-100', 'icon' => 'check-circle'],
                                            'pending' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900', 'text' => 'text-yellow-800 dark:text-yellow-100', 'icon' => 'clock'],
                                            'unpaid' => ['bg' => 'bg-red-100 dark:bg-red-900', 'text' => 'text-red-800 dark:text-red-100', 'icon' => 'exclamation-circle'],
                                            'cancelled' => ['bg' => 'bg-gray-100 dark:bg-gray-900', 'text' => 'text-gray-800 dark:text-gray-100', 'icon' => 'times-circle'],
                                        ];
                                        $config = $statusConfig[$invoice->status] ?? $statusConfig['unpaid'];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $config['bg'] }} {{ $config['text'] }}">
                                        <i class="fas fa-{{ $config['icon'] }} mr-1"></i>{{ ucfirst($invoice->status) }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Items Table -->
            <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-list mr-2 text-blue-600"></i>Invoice Items
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 border-b-2 border-gray-300 dark:border-gray-600">
                                <th class="text-left py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">Description</th>
                                <th class="text-center py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">Period</th>
                                <th class="text-right py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <td class="py-4 px-4">
                                    <div class="font-semibold text-gray-900 dark:text-white">
                                        @if($invoice->package)
                                            {{ $invoice->package->name }}
                                        @elseif($detail && $detail->package_name)
                                            {{ $detail->package_name }}
                                        @else
                                            Internet Service Package
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        Monthly Subscription
                                    </div>
                                    @if($invoice->note)
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-2 italic">
                                            <i class="fas fa-sticky-note mr-1"></i>{{ $invoice->note }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center text-gray-700 dark:text-gray-300">
                                    {{ \Carbon\Carbon::parse($invoice->billing_date)->format('M d') }} - 
                                    {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                                </td>
                                <td class="py-4 px-4 text-right font-semibold text-gray-900 dark:text-white text-lg">
                                    ৳{{ number_format($invoice->package_price, 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Totals Section -->
            <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-end">
                    <div class="w-full md:w-96 space-y-3">
                        <div class="flex justify-between py-2 text-gray-700 dark:text-gray-300">
                            <span>Subtotal:</span>
                            <span class="font-semibold">৳{{ number_format($invoice->package_price, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-2 text-gray-700 dark:text-gray-300 border-t border-gray-300 dark:border-gray-600">
                            <span>Tax (0%):</span>
                            <span class="font-semibold">৳0.00</span>
                        </div>
                        <div class="flex justify-between py-3 text-xl font-bold text-gray-900 dark:text-white border-t-2 border-gray-400 dark:border-gray-500">
                            <span>Total Amount:</span>
                            <span class="text-blue-600">৳{{ number_format($invoice->package_price, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Status Banner -->
            <div class="p-8">
                @if($invoice->status == 'paid')
                    <div class="bg-green-50 dark:bg-green-900 dark:bg-opacity-20 border-l-4 border-green-500 p-4 rounded">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 text-3xl mr-4"></i>
                            <div>
                                <p class="font-semibold text-green-800 dark:text-green-200 text-lg">Payment Received</p>
                                <p class="text-sm text-green-700 dark:text-green-300 mt-1">
                                    This invoice has been paid in full. Thank you for your payment!
                                </p>
                                @if($invoice->transaction_id)
                                    <p class="text-xs text-green-600 dark:text-green-400 mt-2">
                                        Transaction ID: {{ $invoice->transaction_id }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif($invoice->status == 'pending' || $invoice->status == 'unpaid')
                    <div class="bg-yellow-50 dark:bg-yellow-900 dark:bg-opacity-20 border-l-4 border-yellow-500 p-4 rounded">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-yellow-500 text-3xl mr-4"></i>
                                <div>
                                    <p class="font-semibold text-yellow-800 dark:text-yellow-200 text-lg">Payment Pending</p>
                                    <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                                        Please make payment before {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }} to avoid service interruption.
                                    </p>
                                    @if(\Carbon\Carbon::parse($invoice->due_date)->isPast())
                                        <p class="text-xs text-red-600 dark:text-red-400 mt-2 font-semibold">
                                            <i class="fas fa-exclamation-circle mr-1"></i>This invoice is overdue!
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('customer.payments') }}" 
                               class="ml-4 px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold transition whitespace-nowrap">
                                Pay Now
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Footer Notes -->
            <div class="p-8 bg-gray-50 dark:bg-gray-700 rounded-b-lg">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Payment Information:</h4>
                <div class="text-sm text-gray-600 dark:text-gray-400 space-y-2">
                    <p><i class="fas fa-money-bill-wave mr-2 text-green-600"></i><strong>Payment Methods:</strong> Bank Transfer, bKash, Nagad, Cash</p>
                    <p><i class="fas fa-calendar-check mr-2 text-blue-600"></i><strong>Terms:</strong> Payment due within 30 days from invoice date.</p>
                    <p><i class="fas fa-info-circle mr-2 text-purple-600"></i><strong>Note:</strong> For any queries regarding this invoice, please contact our support team.</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-center space-x-4">
            @if($invoice->status == 'pending' || $invoice->status == 'unpaid')
                <a href="{{ route('customer.payments') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                    <i class="fas fa-credit-card mr-2"></i> Make Payment
                </a>
            @endif
            <button onclick="window.print()" 
                    class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-semibold transition">
                <i class="fas fa-print mr-2"></i> Print Invoice
            </button>
            <a href="{{ route('customer.invoices.download', $invoice->id) }}" 
               class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition">
                <i class="fas fa-download mr-2"></i> Download PDF
            </a>
        </div>
    </div>
</div>

<style>
    @media print {
        nav, footer, .no-print, button, a[href*="payments"], a[href*="download"], a[href*="Back"] {
            display: none !important;
        }
        body {
            background: white;
        }
        .bg-gray-800, .dark\:bg-gray-800 {
            background: white !important;
            color: black !important;
        }
    }
</style>

@endsection