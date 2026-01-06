@extends('layouts.app')

@section('title', 'Invoice Details')

@section('content')

<!-- ===== Alerts ===== -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- ===== Top Header & Actions ===== -->
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body py-3">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">

            <!-- Title -->
            <h1 class="h4 mb-0 d-flex align-items-center">
                <i class="fas fa-file-invoice text-primary me-2"></i>
                Invoice: {{ $sale->invoice_no }}
            </h1>

            <!-- Action Buttons -->
            <div class="d-flex flex-wrap gap-2">

                <form method="POST" action="{{ route('sales.credit-note', $sale) }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-file-invoice-dollar me-1"></i> Credit Note
                    </button>
                </form>

                <form method="POST" action="{{ route('sales.debit-note', $sale) }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-file-invoice me-1"></i> Debit Note
                    </button>
                </form>

                <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>

            </div>
        </div>
    </div>
</div>

<!-- ===== Invoice Content ===== -->
<div class="card shadow border-0">
    <div class="card-body">

        <!-- Invoice Info -->
        <h5 class="mb-3">Invoice Information</h5>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Invoice No:</strong> {{ $sale->invoice_no }}</div>
            <div class="col-md-4"><strong>Receipt Type:</strong> {{ $sale->receipt_type }}</div>
            <div class="col-md-4"><strong>Date:</strong> {{ $sale->receipt_date?->format('Y-m-d H:i') }}</div>
        </div>

        <!-- Buyer Info -->
        <h5 class="mb-3">Buyer Information</h5>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Registered Name:</strong> {{ $sale->buyer_register_name }}</div>
            <div class="col-md-4"><strong>Trade Name:</strong> {{ $sale->buyer_trade_name }}</div>
            <div class="col-md-4"><strong>TIN:</strong> {{ $sale->buyer_tin ?? '—' }}</div>
            <div class="col-md-4"><strong>VAT No:</strong> {{ $sale->vat_number ?? '—' }}</div>
            <div class="col-md-4"><strong>Phone:</strong> {{ data_get($sale->buyer_contacts, 'phoneNo', '—') }}</div>
            <div class="col-md-4"><strong>Email:</strong> {{ data_get($sale->buyer_contacts, 'email', '—') }}</div>
        </div>

        <div class="mb-4">
            <strong>Address:</strong>
            {{ data_get($sale->buyer_address, 'houseNo') }} ,
            {{ data_get($sale->buyer_address, 'street') }} ,
            {{ data_get($sale->buyer_address, 'district') }} ,
            {{ data_get($sale->buyer_address, 'city') }} ,
            {{ data_get($sale->buyer_address, 'province') }}
        </div>

        <!-- Items -->
        <h5 class="mb-3">Items</h5>
        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th class="text-end">Price</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Total</th>
                        <th class="text-center">Tax %</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->formatted_receipt_lines as $line)
                        <tr>
                            <td>{{ $line['receiptLineNo'] }}</td>
                            <td>{{ $line['receiptLineName'] }}</td>
                            <td class="text-end">{{ number_format($line['receiptLinePrice'], 2) }}</td>
                            <td class="text-center">{{ $line['receiptLineQuantity'] }}</td>
                            <td class="text-end">{{ number_format($line['receiptLineTotal'], 2) }}</td>
                            <td class="text-center">{{ $line['taxPercent'] }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Taxes -->
        <h5 class="mb-3">Taxes</h5>
        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Tax Code</th>
                        <th class="text-center">%</th>
                        <th class="text-end">Tax Amount</th>
                        <th class="text-end">Sales Amount (With Tax)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->formatted_receipt_taxes as $tax)
                        <tr>
                            <td>{{ $tax['taxCode'] }}</td>
                            <td class="text-center">{{ $tax['taxPercent'] }}%</td>
                            <td class="text-end">{{ number_format($tax['taxAmount'], 2) }}</td>
                            <td class="text-end">{{ number_format($tax['salesAmountWithTax'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Payments -->
        <h5 class="mb-3">Payments</h5>
        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Payment Type</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->formatted_receipt_payments as $payment)
                        <tr>
                            <td>{{ $payment['moneyTypeCode'] }}</td>
                            <td class="text-end">{{ number_format($payment['paymentAmount'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        <div class="row mb-4">
            <div class="col-md-4">
                <strong>Total:</strong>
                {{ number_format($sale->receipt_total, 2) }} {{ $sale->receipt_currency }}
            </div>
            <div class="col-md-8">
                <strong>Notes:</strong> {{ $sale->receipt_notes }}
            </div>
        </div>

        <!-- Footer -->
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong>Created by:</strong>
                {{ $sale->username }} {{ $sale->username_surname }}
            </div>

            <a href="#" class="btn btn-secondary btn-sm">
                <i class="fas fa-print me-1"></i> Print Invoice
            </a>
        </div>

    </div>
</div>

@endsection
