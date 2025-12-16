@extends('layouts.app')

@section('title', 'Fiscal Device Details')

@section('content')
<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-eye text-info mr-2"></i> Fiscal Device Details
</h1>

<div class="card shadow border-0">
    <div class="card-body">
        <dl class="row">

            <dt class="col-sm-4">Device ID</dt>
            <dd class="col-sm-8">{{ $fiscalDevice->device_id }}</dd>

            <dt class="col-sm-4">Model</dt>
            <dd class="col-sm-8">{{ $fiscalDevice->device_model_name }}</dd>

            <dt class="col-sm-4">Version</dt>
            <dd class="col-sm-8">{{ $fiscalDevice->device_model_version }}</dd>

            <dt class="col-sm-4">Serial Number</dt>
            <dd class="col-sm-8">{{ $fiscalDevice->serial_number }}</dd>

            <hr class="col-12">

            <dt class="col-sm-4">Taxpayer Name</dt>
            <dd class="col-sm-8">{{ $fiscalDevice->taxpayer_name }}</dd>

            <dt class="col-sm-4">TIN</dt>
            <dd class="col-sm-8">{{ $fiscalDevice->tin_number }}</dd>

            <dt class="col-sm-4">VAT</dt>
            <dd class="col-sm-8">{{ $fiscalDevice->vat_number ?? 'N/A' }}</dd>

            <hr class="col-12">

            <dt class="col-sm-4">Address</dt>
            <dd class="col-sm-8">
                {{ $fiscalDevice->house_number }},
                {{ $fiscalDevice->street }},
                {{ $fiscalDevice->town }},
                {{ $fiscalDevice->province }}
            </dd>

        </dl>

        <a href="{{ route('device.index') }}" class="btn btn-secondary mt-3">
            Back
        </a>
    </div>
</div>
@endsection
