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
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            color: #000;
            background: #fff;
            padding: 12mm;
            font-size: 10pt;
            line-height: 1.6;
        }

        .invoice-container {
            width: 100%;
            max-width: 100%;
            background: white;
            margin: 0;
            padding: 0;
        }

        /* Header Section - Using Table for Layout */
        .invoice-header {
            width: 100%;
            margin-bottom: 25pt;
            padding-bottom: 18pt;
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
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 10pt;
            color: #000;
            letter-spacing: 0.5pt;
        }

        .company-name {
            font-weight: 600;
            margin-bottom: 6pt;
            color: #000;
            font-size: 10pt;
        }

        .company-details {
            font-size: 8.5pt;
            color: #4b5563;
            line-height: 1.7;
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
            font-size: 24pt;
            font-weight: bold;
            margin-bottom: 14pt;
            color: #000;
            letter-spacing: 0.5pt;
        }

        .invoice-info {
            font-size: 8.5pt;
            line-height: 2;
            color: #4b5563;
        }

        .invoice-info strong {
            color: #000;
            font-weight: bold;
        }

        .payment-status {
            color: #059669;
            font-weight: 600;
            margin-top: 8pt;
            font-size: 10pt;
        }

        /* Billed To Section */
        .billed-to {
            margin-bottom: 20pt;
        }

        .billed-to-title {
            font-weight: bold;
            margin-bottom: 10pt;
            color: #000;
            font-size: 9.5pt;
            letter-spacing: 0.3pt;
        }

        .billed-to-content {
            font-size: 8.5pt;
            line-height: 1.7;
            color: #4b5563;
        }

        /* Table Section */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20pt;
            margin-left: 0;
            margin-right: 0;
            padding: 0;
            table-layout: fixed;
        }

        .invoice-table thead {
            background: transparent;
        }

        .invoice-table th {
            padding: 10pt 14pt;
            text-align: left;
            font-weight: bold;
            font-size: 7.5pt;
            text-transform: uppercase;
            color: #000;
            border-bottom: 1px solid #e5e7eb;
            letter-spacing: 0.2pt;
            white-space: nowrap;
        }

        .invoice-table th:nth-child(1) {
            width: 22%;
            padding-left: 0;
        }

        .invoice-table th:nth-child(2) {
            width: 12%;
        }

        .invoice-table th:nth-child(3) {
            width: 15%;
        }

        .invoice-table th:nth-child(4) {
            width: 19%;
        }

        .invoice-table th:nth-child(5) {
            width: 10%;
        }

        .invoice-table th:nth-child(6) {
            width: 22%;
            padding-right: 0;
        }

        .invoice-table td {
            padding: 12pt 14pt;
            text-align: left;
            border-bottom: 1px solid #f3f4f6;
            font-size: 8.5pt;
            color: #1f2937;
            vertical-align: top;
        }

        .invoice-table td:nth-child(1) {
            word-wrap: break-word;
            padding-left: 0;
        }

        .invoice-table td:nth-child(2),
        .invoice-table td:nth-child(3),
        .invoice-table td:nth-child(4),
        .invoice-table td:nth-child(5) {
            white-space: nowrap;
        }

        .invoice-table td:nth-child(6) {
            white-space: nowrap;
            padding-right: 0;
        }

        .service-description {
            font-weight: bold;
            color: #000;
            font-size: 8.5pt;
            margin-bottom: 4pt;
        }

        .service-dates {
            font-size: 7.5pt;
            color: #6b7280;
            font-weight: normal;
            margin-top: 4pt;
            line-height: 1.5;
        }

        .amount-bold {
            font-weight: bold;
            color: #000;
            font-size: 8.5pt;
        }

        /* Summary Section - Using Table for Layout */
        .invoice-summary {
            width: 100%;
            margin-top: 15pt;
        }

        .summary-table {
            width: 300pt;
            margin-left: auto;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 6pt 0;
            font-size: 8.5pt;
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
            padding-top: 10pt;
            margin-top: 6pt;
        }

        .summary-total td {
            padding-top: 10pt;
        }

        /* PDF-specific optimizations */
        @page {
            margin: 12mm;
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
