@extends('layouts.app')

@section('title', 'Invoice Details')

@section('content')
<div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between mb-4 gap-3">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-file-invoice text-primary mr-2"></i> Invoice: {{ $sale->invoice_no }}
    </h1>
    <a href="{{ route('sales.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Back to Sales
    </a>
</div>

<div class="card shadow border-0">
    <div class="card-body">
        <!-- Invoice Info -->
        <h5 class="mb-3">Invoice Info</h5>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Invoice No:</strong> {{ $sale->invoice_no }}</div>
            <div class="col-md-4"><strong>Receipt Type:</strong> {{ $sale->receipt_type }}</div>
            <div class="col-md-4"><strong>Date:</strong> {{ $sale->receipt_date->format('Y-m-d H:i') }}</div>
        </div>

        <!-- Buyer Info -->
        <h5 class="mb-3">Buyer Information</h5>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Registered Name:</strong> {{ $sale->buyer_register_name }}</div>
            <div class="col-md-4"><strong>Trade Name:</strong> {{ $sale->buyer_trade_name }}</div>
            <div class="col-md-4"><strong>TIN:</strong> {{ $sale->buyer_tin ?? '—' }}</div>
            <div class="col-md-4"><strong>VAT Number:</strong> {{ $sale->vat_number ?? '—' }}</div>
            <div class="col-md-4"><strong>Phone:</strong> {{ $sale->buyer_contacts['phoneNo'] ?? '—' }}</div>
            <div class="col-md-4"><strong>Email:</strong> {{ $sale->buyer_contacts['email'] ?? '—' }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12"><strong>Address:</strong>
                {{ $sale->buyer_address['houseNo'] ?? '' }},
                {{ $sale->buyer_address['street'] ?? '' }},
                {{ $sale->buyer_address['district'] ?? '' }},
                {{ $sale->buyer_address['city'] ?? '' }},
                {{ $sale->buyer_address['province'] ?? '' }}
            </div>
        </div>

        <!-- Receipt Lines -->
        <h5 class="mb-3">Items</h5>
        <div class="table-responsive mb-3">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Tax Code</th>
                        <th>Tax %</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->receipt_lines as $line)
                        <tr>
                            <td>{{ $line['receiptLineNo'] }}</td>
                            <td>{{ $line['receiptLineName'] }}</td>
                            <td>{{ number_format($line['receiptLinePrice'], 2) }}</td>
                            <td>{{ $line['receiptLineQuantity'] }}</td>
                            <td>{{ number_format($line['receiptLineTotal'], 2) }}</td>
                            <td>{{ $line['taxCode'] }}</td>
                            <td>{{ $line['taxPercent'] }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Taxes -->
        <h5 class="mb-3">Taxes</h5>
        <div class="table-responsive mb-3">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Tax Code</th>
                        <th>Tax %</th>
                        <th>Tax Amount</th>
                        <th>Sales Amount with Tax</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->receipt_taxes as $tax)
                        <tr>
                            <td>{{ $tax['taxCode'] }}</td>
                            <td>{{ $tax['taxPercent'] }}%</td>
                            <td>{{ number_format($tax['taxAmount'], 2) }}</td>
                            <td>{{ number_format($tax['salesAmountWithTax'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Payments -->
        <h5 class="mb-3">Payments</h5>
        <div class="table-responsive mb-3">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Payment Type</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->receipt_payments as $payment)
                        <tr>
                            <td>{{ $payment['moneyTypeCode'] }}</td>
                            <td>{{ number_format($payment['paymentAmount'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total & Notes -->
        <div class="row mb-3">
            <div class="col-md-4"><strong>Total:</strong> {{ number_format($sale->receipt_total, 2) }} {{ $sale->receipt_currency }}</div>
            <div class="col-md-8"><strong>Notes:</strong> {{ $sale->receipt_notes }}</div>
        </div>

        <!-- User & Device Info -->
        <div class="row mb-3">
            <div class="col-md-4"><strong>Created by:</strong> {{ $sale->username }} {{ $sale->username_surname }}</div>
            <div class="col-md-4"><strong>Device Hash:</strong> {{ $sale->device_hash ?? '—' }}</div>
            <div class="col-md-4"><strong>Device Signature:</strong> {{ $sale->device_signature ?? '—' }}</div>
        </div>

        <div class="text-end">
            <a href="" target="_blank" class="btn btn-secondary">
                <i class="fas fa-print"></i> Print Invoice
            </a>
        </div>
    </div>
</div>
@endsection
