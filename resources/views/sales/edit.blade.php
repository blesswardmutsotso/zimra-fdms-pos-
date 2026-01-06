@extends('layouts.app')

@section('title', 'Edit Invoice')

@section('content')
<div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between mb-4 gap-3">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-file-invoice text-primary mr-2"></i>
        Edit Invoice: {{ $sale->invoice_no }}
    </h1>
    <a href="{{ route('sales.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Back to Sales
    </a>
</div>

<form action="{{ route('sales.update', $sale->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card shadow border-0">
        <div class="card-body">

            {{-- Invoice Info --}}
            <h5 class="mb-3">Invoice Info</h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Invoice No</label>
                    <input type="text" class="form-control" value="{{ $sale->invoice_no }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Receipt Type</label>
                    <input type="text" class="form-control" value="{{ $sale->receipt_type }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date</label>
                    <input type="text" class="form-control"
                           value="{{ $sale->receipt_date->format('Y-m-d H:i') }}" readonly>
                </div>
            </div>

            {{-- Buyer Info --}}
            <h5 class="mb-3">Buyer Information</h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Registered Name</label>
                    <input type="text" name="buyer_register_name" class="form-control"
                           value="{{ $sale->buyer_register_name }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Trade Name</label>
                    <input type="text" name="buyer_trade_name" class="form-control"
                           value="{{ $sale->buyer_trade_name }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">TIN</label>
                    <input type="text" name="buyer_tin" class="form-control"
                           value="{{ $sale->buyer_tin }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">VAT Number</label>
                    <input type="text" name="vat_number" class="form-control"
                           value="{{ $sale->vat_number }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Phone</label>
                    <input type="text" name="buyer_contacts[phoneNo]" class="form-control"
                           value="{{ $sale->buyer_contacts['phoneNo'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="buyer_contacts[email]" class="form-control"
                           value="{{ $sale->buyer_contacts['email'] ?? '' }}">
                </div>
            </div>

            {{-- Address --}}
            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Address</label>
                    <input type="text" name="buyer_address[street]" class="form-control mb-1"
                           placeholder="Street" value="{{ $sale->buyer_address['street'] ?? '' }}">
                    <input type="text" name="buyer_address[city]" class="form-control mb-1"
                           placeholder="City" value="{{ $sale->buyer_address['city'] ?? '' }}">
                    <input type="text" name="buyer_address[province]" class="form-control"
                           placeholder="Province" value="{{ $sale->buyer_address['province'] ?? '' }}">
                </div>
            </div>

            {{-- Items --}}
            <h5 class="mb-3">Items</h5>
            <div class="table-responsive mb-3">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Tax %</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->receipt_lines as $i => $line)
                        <tr>
                            <td>{{ $line['receiptLineNo'] ?? $i + 1 }}</td>
                            <td>
                                <input type="text"
                                       name="receipt_lines[{{ $i }}][receiptLineName]"
                                       class="form-control"
                                       value="{{ $line['receiptLineName'] ?? $line['description'] ?? '' }}">
                            </td>
                            <td>
                                <input type="number" step="0.01"
                                       name="receipt_lines[{{ $i }}][receiptLinePrice]"
                                       class="form-control"
                                       value="{{ $line['receiptLinePrice'] ?? $line['unit_price'] ?? 0 }}">
                            </td>
                            <td>
                                <input type="number"
                                       name="receipt_lines[{{ $i }}][receiptLineQuantity]"
                                       class="form-control"
                                       value="{{ $line['receiptLineQuantity'] ?? $line['quantity'] ?? 0 }}">
                            </td>
                            <td>
                                <input type="number" step="0.01"
                                       name="receipt_lines[{{ $i }}][receiptLineTotal]"
                                       class="form-control"
                                       value="{{ $line['receiptLineTotal'] ?? $line['line_total'] ?? 0 }}">
                            </td>
                            <td>
                                <input type="number"
                                       name="receipt_lines[{{ $i }}][taxPercent]"
                                       class="form-control"
                                       value="{{ $line['taxPercent'] ?? 0 }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Payments --}}
            <h5 class="mb-3">Payments</h5>
            <div class="table-responsive mb-3">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Type</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->receipt_payments as $p => $payment)
                        <tr>
                            <td>
                                <input type="text"
                                       name="receipt_payments[{{ $p }}][moneyTypeCode]"
                                       class="form-control"
                                       value="{{ $payment['moneyTypeCode'] ?? $payment['method'] ?? '' }}">
                            </td>
                            <td>
                                <input type="number" step="0.01"
                                       name="receipt_payments[{{ $p }}][paymentAmount]"
                                       class="form-control"
                                       value="{{ $payment['paymentAmount'] ?? $payment['amount'] ?? 0 }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Total & Notes --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Total</label>
                    <input type="number" step="0.01" name="receipt_total"
                           class="form-control" value="{{ $sale->receipt_total }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Notes</label>
                    <textarea name="receipt_notes" class="form-control"
                              rows="2">{{ $sale->receipt_notes }}</textarea>
                </div>
            </div>

            {{-- Actions --}}
            <div class="text-end">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update Invoice
                </button>
                <a href="{{ route('sales.print', $sale->id) }}"
                   target="_blank" class="btn btn-secondary">
                    <i class="fas fa-print"></i> Print Invoice
                </a>
            </div>

        </div>
    </div>
</form>
@endsection
