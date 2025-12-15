@extends('layouts.app')

@section('title', 'Client Details')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-building text-success mr-2"></i> Client Details
    </h1>

    <a href="{{ route('client-details.edit', Crypt::encryptString($clientDetail->id)) }}"
       class="btn btn-sm btn-success shadow-sm">
        <i class="fas fa-edit mr-1"></i> Edit
    </a>
</div>

<div class="card shadow border-left-success">
    <div class="card-body">

        <div class="row mb-3">
            <div class="col-md-4 text-muted">Company Name</div>
            <div class="col-md-8 font-weight-bold">{{ $clientDetail->company_name }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 text-muted">TIN</div>
            <div class="col-md-8 font-weight-bold">{{ $clientDetail->tin }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 text-muted">VAT Number</div>
            <div class="col-md-8">
                {{ $clientDetail->vat_number ?? '—' }}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 text-muted">Address</div>
            <div class="col-md-8">
                {{ $clientDetail->address }}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 text-muted">Phone</div>
            <div class="col-md-8">
                {{ $clientDetail->phone ?? '—' }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 text-muted">Email</div>
            <div class="col-md-8">
                {{ $clientDetail->email ?? '—' }}
            </div>
        </div>

    </div>
</div>

@endsection
