<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $sale->invoice_no }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body { font-size: 12px; line-height: 1.3; color: #212529; margin: 0; padding: 0; }
        .container-fluid { padding: 10px; }
        .invoice-header { margin-bottom: 10px; border-bottom: 1px solid #dee2e6; padding-bottom: 5px; display: flex; justify-content: space-between; align-items: center; }
        .section-title { font-weight: 600; margin-top: 15px; margin-bottom: 10px; font-size: 13px; }
        .table th, .table td { padding: 0.35rem; vertical-align: middle; font-size: 12px; }
        .table thead th { background-color: rgba(0, 123, 255, 0.1); font-size: 12px; }
        .total-row { font-weight: bold; background-color: rgba(0, 0, 0, 0.05); }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .invoice-footer { margin-top: 15px; font-size: 11px; color: #6c757d; border-top: 1px solid #dee2e6; padding-top: 5px; }
        .qr-section { margin-top: 10px; display: flex; justify-content: center; }
        .qr-box { border: 1px solid #dee2e6; padding: 5px; width: 120px; height: 120px; display: flex; align-items: center; justify-content: center; }
        .no-break { page-break-inside: avoid; }
        .table-container { display: flex; justify-content: center; }
        .table-lg { width: 100%; }

        /* Landscape Print */
        @media print {
            body { -webkit-print-color-adjust: exact; }
            @page { size: A4 landscape; margin: 10mm; }
        }
    </style>
</head>
<body>
<div class="container-fluid">

    <!-- Header -->
    <div class="invoice-header no-break">
        <div class="text-center w-100">
            <h3>Invoice</h3>
        </div>
        <div class="text-end">
            <h5>#{{ $sale->invoice_no }}</h5>
            <p><strong>Date:</strong> {{ $sale->receipt_date->format('Y-m-d H:i') }}</p>
            <p><strong>Type:</strong> {{ $sale->receipt_type }}</p>
        </div>
    </div>

    <!-- Buyer Info -->
    <div class="section-title">Buyer Information</div>
    <div class="row no-break">
        <div class="col-md-3"><strong>Registered Name:</strong> {{ $sale->buyer_register_name }}</div>
        <div class="col-md-3"><strong>Trade Name:</strong> {{ $sale->buyer_trade_name }}</div>
        <div class="col-md-2"><strong>TIN:</strong> {{ $sale->buyer_tin ?? '—' }}</div>
        <div class="col-md-2"><strong>VAT:</strong> {{ $sale->vat_number ?? '—' }}</div>
        <div class="col-md-2"><strong>Phone:</strong> {{ $sale->buyer_contacts['phoneNo'] ?? '—' }}</div>
        <div class="col-md-3"><strong>Email:</strong> {{ $sale->buyer_contacts['email'] ?? '—' }}</div>
        <div class="col-md-12 mt-1"><strong>Address:</strong> {{ implode(', ', array_filter([ $sale->buyer_address['houseNo'] ?? null, $sale->buyer_address['street'] ?? null, $sale->buyer_address['city'] ?? null, $sale->buyer_address['province'] ?? null ])) }}</div>
    </div>

    <!-- Items Table -->
    <div class="section-title">Items</div>
    <div class="table-container no-break">
        <table class="table table-bordered table-striped table-lg">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="text-right">Price</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Total</th>
                    <th class="text-right">Tax %</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->receipt_lines as $line)
                    <tr>
                        <td>{{ $line['receiptLineName'] }}</td>
                        <td class="text-right">{{ number_format($line['receiptLinePrice'], 2) }}</td>
                        <td class="text-center">{{ $line['receiptLineQuantity'] }}</td>
                        <td class="text-right">{{ number_format($line['receiptLineTotal'], 2) }}</td>
                        <td class="text-right">{{ $line['taxPercent'] ?? 0 }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Summary -->
    @php
        $totalTax = collect($sale->receipt_lines)->sum(fn($line) => $line['receiptLineTotal'] * ($line['taxPercent'] ?? 0) / 100);
        $subTotal = $sale->receipt_total - $totalTax;
    @endphp

    <div class="mt-2 text-end no-break">
        <p><strong>Subtotal:</strong> {{ number_format($subTotal, 2) }} {{ $sale->receipt_currency }}</p>
        <p><strong>Total Tax:</strong> {{ number_format($totalTax, 2) }} {{ $sale->receipt_currency }}</p>
        <h5><strong>Invoice Total:</strong> {{ number_format($sale->receipt_total, 2) }} {{ $sale->receipt_currency }}</h5>
    </div>

    <!-- QR Code Section (Centered) -->
    <div class="qr-section no-break">
        <div class="qr-box">
            <img src="" alt="QR Code" style="max-width: 100%; max-height: 100%;">
        </div>
    </div>

    <!-- Footer -->
    <div class="invoice-footer text-center no-break">
        Printed from the system | Generated on {{ now()->format('Y-m-d H:i') }}
    </div>
</div>

<script>
    window.onload = function() { window.print(); };
</script>
</body>
</html>
