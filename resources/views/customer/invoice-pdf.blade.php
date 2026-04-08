<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 13px;
            color: #333;
            line-height: 1.6;
            padding: 30px;
        }
        .header {
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #2563eb;
        }
        .header-content {
            display: table;
            width: 100%;
        }
        .header-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .header-right {
            display: table-cell;
            width: 50%;
            text-align: right;
            vertical-align: top;
        }
        .company-name {
            font-size: 26px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 5px;
        }
        .company-tagline {
            font-size: 12px;
            color: #666;
        }
        .invoice-title {
            font-size: 32px;
            font-weight: bold;
            color: #333;
        }
        .invoice-number {
            font-size: 18px;
            color: #666;
            margin-top: 5px;
        }
        .info-section {
            margin: 25px 0;
        }
        .info-table {
            width: 100%;
        }
        .info-table td {
            padding: 8px 0;
            vertical-align: top;
        }
        .info-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .info-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2563eb;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
        }
        .items-table thead {
            background-color: #f3f4f6;
        }
        .items-table th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #ddd;
        }
        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .totals {
            float: right;
            width: 300px;
            margin-top: 15px;
        }
        .totals-row {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .totals-row:after {
            content: "";
            display: table;
            clear: both;
        }
        .totals-label {
            float: left;
        }
        .totals-value {
            float: right;
            font-weight: bold;
        }
        .total-row {
            font-size: 18px;
            font-weight: bold;
            border-top: 2px solid #333;
            padding-top: 10px;
            margin-top: 10px;
            color: #2563eb;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 11px;
        }
        .status-paid {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-unpaid {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .status-cancelled {
            background-color: #e5e7eb;
            color: #4b5563;
        }
        .payment-notice {
            margin-top: 30px;
            padding: 15px;
            border-left: 4px solid #f59e0b;
            background-color: #fef3c7;
            border-radius: 5px;
        }
        .payment-notice.paid {
            border-left-color: #10b981;
            background-color: #d1fae5;
        }
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 11px;
            color: #666;
        }
        .footer p {
            margin: 5px 0;
        }
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <div class="header-left">
                <div class="company-name">BetterNet ISP</div>
                <div class="company-tagline">Internet Service Provider</div>
                <div style="margin-top: 12px; color: #666; font-size: 11px;">
                    <div>📧 Email: support@betternet.com</div>
                    <div>📞 Phone: +880 1234-567890</div>
                    <div>🌐 Web: www.betternet.com</div>
                </div>
            </div>
            <div class="header-right">
                <div class="invoice-title">INVOICE</div>
                <div class="invoice-number">#{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</div>
                <div style="margin-top: 15px; font-size: 12px;">
                    <div><strong>Invoice Date:</strong> {{ \Carbon\Carbon::parse($invoice->billing_date)->format('M d, Y') }}</div>
                    <div><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer & Invoice Info -->
    <div class="info-section">
        <table class="info-table">
            <tr>
                <td style="width: 50%;">
                    <div class="info-box">
                        <div class="info-title">BILL TO:</div>
                        <div><strong style="font-size: 15px;">{{ $customer->name }}</strong></div>
                        <div style="margin-top: 8px;">{{ $customer->email }}</div>
                        <div>{{ $customer->phone ?? 'N/A' }}</div>
                        @if($detail && $detail->address)
                            <div style="margin-top: 5px; font-size: 11px;">{{ $detail->address }}</div>
                        @endif
                        <div style="margin-top: 10px; font-size: 10px; color: #666;">
                            Customer ID: #{{ str_pad($customer->id, 5, '0', STR_PAD_LEFT) }}
                        </div>
                    </div>
                </td>
                <td style="width: 50%;">
                    <div class="info-box">
                        <div class="info-title">INVOICE DETAILS:</div>
                        <table style="width: 100%; font-size: 12px;">
                            <tr>
                                <td><strong>Billing Period:</strong></td>
                                <td style="text-align: right;">
                                    {{ \Carbon\Carbon::parse($invoice->billing_date)->format('M d') }} - 
                                    {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Package:</strong></td>
                                <td style="text-align: right;">
                                    @if($invoice->package)
                                        {{ $invoice->package->name }}
                                    @elseif($detail && $detail->package_name)
                                        {{ $detail->package_name }}
                                    @else
                                        Internet Service
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 10px;"><strong>Status:</strong></td>
                                <td style="text-align: right; padding-top: 10px;">
                                    @php
                                        $statusClass = 'status-' . $invoice->status;
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ strtoupper($invoice->status) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Invoice Items -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 50%;">Description</th>
                <th class="text-center" style="width: 25%;">Billing Period</th>
                <th class="text-right" style="width: 25%;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong style="font-size: 14px;">
                        @if($invoice->package)
                            {{ $invoice->package->name }}
                        @elseif($detail && $detail->package_name)
                            {{ $detail->package_name }}
                        @else
                            Internet Service Package
                        @endif
                    </strong>
                    <div style="font-size: 11px; color: #666; margin-top: 5px;">
                        Monthly Internet Subscription
                    </div>
                    @if($invoice->note)
                        <div style="font-size: 10px; color: #999; margin-top: 5px; font-style: italic;">
                            Note: {{ $invoice->note }}
                        </div>
                    @endif
                </td>
                <td class="text-center">
                    {{ \Carbon\Carbon::parse($invoice->billing_date)->format('M d') }} - 
                    {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                </td>
                <td class="text-right">
                    <strong style="font-size: 15px;">৳{{ number_format($invoice->package_price, 2) }}</strong>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Totals -->
    <div class="clearfix">
        <div class="totals">
            <div class="totals-row">
                <span class="totals-label">Subtotal:</span>
                <span class="totals-value">৳{{ number_format($invoice->package_price, 2) }}</span>
            </div>
            <div class="totals-row">
                <span class="totals-label">Tax (0%):</span>
                <span class="totals-value">৳0.00</span>
            </div>
            <div class="totals-row">
                <span class="totals-label">Discount:</span>
                <span class="totals-value">৳0.00</span>
            </div>
            <div class="totals-row total-row">
                <span class="totals-label">TOTAL AMOUNT:</span>
                <span class="totals-value">৳{{ number_format($invoice->package_price, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Payment Status Message -->
    <div style="clear: both; margin-top: 80px;">
        @if($invoice->status == 'paid')
            <div class="payment-notice paid">
                <strong style="color: #065f46; font-size: 14px;">✓ PAYMENT RECEIVED</strong>
                <div style="color: #047857; font-size: 12px; margin-top: 5px;">
                    This invoice has been paid in full. Thank you for your prompt payment!
                </div>
                @if($invoice->transaction_id)
                    <div style="color: #059669; font-size: 10px; margin-top: 5px;">
                        Transaction ID: {{ $invoice->transaction_id }}
                    </div>
                @endif
            </div>
        @else
            <div class="payment-notice">
                <strong style="color: #92400e; font-size: 14px;">⚠ PAYMENT REQUIRED</strong>
                <div style="color: #b45309; font-size: 12px; margin-top: 5px;">
                    Please make payment before <strong>{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</strong> to avoid service interruption.
                </div>
                @if(\Carbon\Carbon::parse($invoice->due_date)->isPast())
                    <div style="color: #dc2626; font-size: 11px; margin-top: 5px; font-weight: bold;">
                        ⚠ This invoice is OVERDUE! Please pay immediately to avoid service suspension.
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Payment Methods:</strong> Bank Transfer | bKash: 01234-567890 | Nagad: 01234-567890 | Cash Payment</p>
        <p><strong>Bank Details:</strong> Bank Asia | Account Name: BetterNet ISP | Account: 1234567890 | Branch: Dhaka</p>
        <p><strong>Terms & Conditions:</strong> Payment is due within 30 days from the invoice date. Late payments may result in service suspension.</p>
        <p style="margin-top: 15px; text-align: center; font-size: 10px;">
            Thank you for choosing BetterNet ISP! For support, contact: support@betternet.com | +880 1234-567890
        </p>
        <p style="text-align: center; font-size: 9px; color: #999; margin-top: 10px;">
            This is a computer-generated invoice and does not require a signature.
        </p>
    </div>
</body>
</html>