<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $payment->invoice_number ?? $payment->transaction_reference }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
            background: #fff;
            padding: 15mm;
            font-size: 12pt;
            line-height: 1.5;
        }

        .invoice-container {
            width: 100%;
            max-width: 100%;
            background: white;
        }

        /* Header Section - Using Table for Layout */
        .invoice-header {
            width: 100%;
            margin-bottom: 20pt;
            padding-bottom: 15pt;
            border-bottom: 1px solid #e5e7eb;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: top;
            padding: 0;
        }

        .company-info {
            width: 50%;
        }

        .company-logo {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 8pt;
            color: #000;
        }

        .company-name {
            font-weight: 600;
            margin-bottom: 5pt;
            color: #000;
            font-size: 11pt;
        }

        .company-details {
            font-size: 9pt;
            color: #4b5563;
            line-height: 1.6;
        }

        .vat-reg {
            font-weight: bold;
            color: #000;
        }

        .invoice-details {
            text-align: right;
            width: 50%;
        }

        .invoice-title {
            font-size: 32pt;
            font-weight: bold;
            font-family: Georgia, serif;
            margin-bottom: 12pt;
            color: #000;
        }

        .invoice-info {
            font-size: 9pt;
            line-height: 1.8;
            color: #4b5563;
        }

        .invoice-info strong {
            color: #000;
            font-weight: bold;
        }

        .payment-status {
            color: #059669;
            font-weight: 600;
            margin-top: 5pt;
            font-size: 11pt;
        }

        /* Billed To Section */
        .billed-to {
            margin-bottom: 15pt;
        }

        .billed-to-title {
            font-weight: bold;
            margin-bottom: 8pt;
            color: #000;
            font-size: 10pt;
        }

        .billed-to-content {
            font-size: 9pt;
            line-height: 1.6;
            color: #4b5563;
        }

        /* Table Section */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15pt;
        }

        .invoice-table thead {
            background: transparent;
        }

        .invoice-table th {
            padding: 8pt 6pt;
            text-align: left;
            font-weight: bold;
            font-size: 8pt;
            text-transform: uppercase;
            color: #000;
            border-bottom: 1px solid #e5e7eb;
        }

        .invoice-table td {
            padding: 10pt 6pt;
            border-bottom: 1px solid #f3f4f6;
            font-size: 9pt;
            color: #1f2937;
        }

        .service-description {
            font-weight: bold;
            color: #000;
        }

        .service-dates {
            font-size: 8pt;
            color: #6b7280;
            font-weight: normal;
            margin-top: 3pt;
        }

        .amount-bold {
            font-weight: bold;
            color: #000;
        }

        /* Summary Section - Using Table for Layout */
        .invoice-summary {
            width: 100%;
            margin-top: 10pt;
        }

        .summary-table {
            width: 280pt;
            margin-left: auto;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 5pt 0;
            font-size: 9pt;
            vertical-align: top;
        }

        .summary-label {
            color: #4b5563;
            text-align: left;
        }

        .summary-value {
            color: #1f2937;
            text-align: right;
        }

        .summary-value.bold {
            font-weight: bold;
            color: #000;
        }

        .summary-value.negative {
            color: #1f2937;
        }

        .summary-total {
            border-top: 1px solid #e5e7eb;
            padding-top: 8pt;
            margin-top: 5pt;
        }

        .summary-total td {
            padding-top: 8pt;
        }

        /* PDF-specific optimizations */
        @page {
            margin: 15mm;
            size: A4 portrait;
        }

        /* Ensure proper rendering in PDF */
        .invoice-header {
            page-break-inside: avoid;
        }

        .invoice-table {
            page-break-inside: avoid;
        }

        .invoice-summary {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <table class="header-table invoice-header">
            <tr>
                <td class="company-info">
                    <div class="company-logo">UNIEXAMS ARCHIVES</div>
                    <div class="company-name">UniExams Archives Ltd.</div>
                    <div class="company-details">
                        <div>Ghana</div>
                        <div class="vat-reg">VAT Reg #: N/A</div>
                    </div>
                </td>
                <td class="invoice-details">
                    <div class="invoice-title">INVOICE</div>
                    <div class="invoice-info">
                        <div>Invoice # <strong>{{ $payment->invoice_number ?? $payment->transaction_reference }}</strong></div>
                        <div>Invoice Issued # <strong>{{ $payment->paid_at ? $payment->paid_at->format('M d, Y') : $payment->created_at->format('M d, Y') }}</strong></div>
                        <div>Invoice Amount # <strong>{{ $payment->currency }} {{ number_format($payment->amount, 2) }} ({{ $payment->currency }})</strong></div>
                        @if($payment->subscription)
                            <div>Next Billing Date # <strong>{{ $payment->subscription->subscription_end_date->format('M d, Y') }}</strong></div>
                        @endif
                        <div>Order Nr. # <strong>{{ $payment->transaction_reference }}</strong></div>
                    </div>
                    <div class="payment-status">PAID</div>
                </td>
            </tr>
        </table>

        <!-- Billed To -->
        <div class="billed-to">
            <div class="billed-to-title">BILLED TO</div>
            <div class="billed-to-content">
                <div>{{ $payment->customer_name ?? ($payment->subscription->institution_name ?? 'N/A') }}</div>
                @if($payment->subscription)
                    <div>{{ $payment->subscription->institution_code ?? '' }}</div>
                @endif
                <div>Ghana</div>
                <div>{{ $payment->customer_email ?? ($payment->user->email ?? 'N/A') }}</div>
                @if($payment->customer_phone)
                    <div>{{ $payment->customer_phone }}</div>
                @endif
            </div>
        </div>

        <!-- Invoice Table -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Total Excl. VAT</th>
                    <th>VAT</th>
                    <th>Amount ({{ $payment->currency }})</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="service-description">
                            {{ ucfirst(str_replace('_', ' ', $payment->transaction_type)) }}
                            @if($payment->subscription)
                                (billed every {{ $payment->subscription->renewal_cycle == 'annual' ? 'year' : $payment->subscription->renewal_cycle }})
                            @endif
                        </div>
                        @if($payment->subscription)
                            <div class="service-dates">
                                {{ $payment->subscription->subscription_start_date->format('M d, Y') }} to {{ $payment->subscription->subscription_end_date->format('M d, Y') }}
                            </div>
                        @endif
                    </td>
                    <td>
                        @if($payment->original_amount && $payment->original_amount != $payment->amount)
                            {{ $payment->currency }} {{ number_format($payment->original_amount, 2) }} x 1
                        @else
                            {{ $payment->currency }} {{ number_format($payment->amount, 2) }} x 1
                        @endif
                    </td>
                    <td>
                        @if($payment->discount_amount && $payment->discount_amount > 0)
                            ({{ $payment->currency }} {{ number_format($payment->discount_amount, 2) }})
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->currency }} 0.00</td>
                    <td class="amount-bold">{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Summary -->
        <table class="summary-table invoice-summary">
            <tr>
                <td class="summary-label">Total excl. VAT:</td>
                <td class="summary-value">{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</td>
            </tr>
            <tr>
                <td class="summary-label">Total:</td>
                <td class="summary-value bold">{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</td>
            </tr>
            <tr>
                <td class="summary-label">Payments:</td>
                <td class="summary-value negative">({{ $payment->currency }} {{ number_format($payment->amount, 2) }})</td>
            </tr>
            <tr class="summary-total">
                <td class="summary-label">Amount Due ({{ $payment->currency }}):</td>
                <td class="summary-value bold">{{ $payment->currency }} 0.00</td>
            </tr>
        </table>
    </div>
</body>
</html>
