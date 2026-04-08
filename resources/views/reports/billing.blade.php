<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Billing History</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #4CAF50;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ddd;
            font-size: 10px;
        }
        td {
            padding: 6px 8px;
            border: 1px solid #ddd;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total-row {
            background-color: #e8f5e9;
            font-weight: bold;
        }
        .status-paid {
            color: #4CAF50;
            font-weight: bold;
        }
        .status-unpaid {
            color: #f44336;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 9px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .summary {
            margin-top: 20px;
            padding: 10px;
            background-color: #f5f5f5;
            font-size: 10px;
        }
        .summary-item {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ config('app.name', 'ISP Billing') }}</h1>
        <p>Billing History Report</p>
        <p>Generated on: {{ date('F d, Y h:i A') }}</p>
    </div>

    @php
        $totalAmount = 0;
        $totalPaid = 0;
        $totalUnpaid = 0;
        $paidCount = 0;
        $unpaidCount = 0;
        $userCount = 0;
    @endphp

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 15%;">Invoice</th>
                <th style="width: 20%;">User Name</th>
                <th style="width: 15%;">Package</th>
                <th style="width: 12%;">Price</th>
                <th style="width: 13%;">Start Date</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 10%;">Paid Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bills as $index => $bill)
                @php
                    $totalAmount += $bill->package_price;
                    
                    // Get user name - handle null user
                    if ($bill->user) {
                        $userName = $bill->user->name;
                        $userCount++;
                    } else {
                        $userName = 'Deleted User';
                    }
                    
                    // Check paid status using status column (not paid column)
                    $isPaid = ($bill->status === 'paid');
                    
                    if ($isPaid) {
                        $totalPaid += $bill->package_price;
                        $paidCount++;
                    } else {
                        $totalUnpaid += $bill->package_price;
                        $unpaidCount++;
                    }
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $bill->invoice }}</td>
                    <td>{{ $userName }}</td>
                    <td>{{ $bill->package_name }}</td>
                    <td>{{ config('app.currency', '৳') }}{{ number_format($bill->package_price, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($bill->package_start)->format('M d, Y') }}</td>
                    <td>
                        @if($isPaid)
                            <span class="status-paid">Paid</span>
                        @else
                            <span class="status-unpaid">{{ ucfirst($bill->status ?? 'Unpaid') }}</span>
                        @endif
                    </td>
                    <td>
                        @if($isPaid && $bill->updated_at)
                            {{ \Carbon\Carbon::parse($bill->updated_at)->format('M d, Y') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px; color: #999;">
                        No billing records found.
                    </td>
                </tr>
            @endforelse
            
            @if($bills->count() > 0)
            <tr class="total-row">
                <td colspan="4" style="text-align: right; padding-right: 10px;">TOTAL:</td>
                <td>{{ config('app.currency', '৳') }}{{ number_format($totalAmount, 2) }}</td>
                <td colspan="3"></td>
            </tr>
            @endif
        </tbody>
    </table>

    @if($bills->count() > 0)
    <div class="summary">
        <div class="summary-item">
            <strong>Total Bills:</strong> {{ $bills->count() }}
        </div>
        <div class="summary-item">
            <strong>Active Users:</strong> {{ $userCount }}
        </div>
        <div class="summary-item">
            <strong>Paid Bills:</strong> {{ $paidCount }}
        </div>
        <div class="summary-item">
            <strong>Unpaid Bills:</strong> {{ $unpaidCount }}
        </div>
        <br>
        <div class="summary-item">
            <strong>Total Amount:</strong> {{ config('app.currency', '৳') }}{{ number_format($totalAmount, 2) }}
        </div>
        <div class="summary-item">
            <strong>Paid Amount:</strong> <span style="color: #4CAF50;">{{ config('app.currency', '৳') }}{{ number_format($totalPaid, 2) }}</span>
        </div>
        <div class="summary-item">
            <strong>Unpaid Amount:</strong> <span style="color: #f44336;">{{ config('app.currency', '৳') }}{{ number_format($totalUnpaid, 2) }}</span>
        </div>
    </div>
    @endif

    <div class="footer">
        <p>This is a computer-generated report. No signature required.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'ISP Billing System') }}. All rights reserved.</p>
    </div>
</body>
</html>