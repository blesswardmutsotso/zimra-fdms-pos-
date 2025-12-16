@extends('layouts.app')

@section('title', 'View Customer')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-user text-primary mr-2"></i> Customer Details</h1>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Back to Customers</a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Name:</strong> {{ $customer->name }}</li>
            <li class="list-group-item"><strong>House No:</strong> {{ $customer->house_number }}</li>
            <li class="list-group-item"><strong>Street:</strong> {{ $customer->street }}</li>
            <li class="list-group-item"><strong>Town:</strong> {{ $customer->town }}</li>
            <li class="list-group-item"><strong>Province:</strong> {{ $customer->province }}</li>
            <li class="list-group-item"><strong>VAT Number:</strong> {{ $customer->vat_number }}</li>
            <li class="list-group-item"><strong>TIN Number:</strong> {{ $customer->tin_number }}</li>
        </ul>
    </div>
</div>
@endsection
