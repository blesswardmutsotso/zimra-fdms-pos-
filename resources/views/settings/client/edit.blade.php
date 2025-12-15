@extends('layouts.app')

@section('title', 'Edit Client Details')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-edit text-muted mr-2"></i> Edit Client Details
    </h1>
</div>

<div class="card shadow-sm border-0 bg-white bg-opacity-75 mb-4" style="backdrop-filter: blur(10px);">
    <div class="card-header bg-transparent border-bottom-0">
        <h5 class="mb-0 text-secondary"><i class="fas fa-user-edit mr-2"></i> Update Client Information</h5>
    </div>
    <div class="card-body">

        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('client-details.update', Crypt::encryptString($clientDetail->id)) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">

                @php
                    $fields = [
                        ['label' => 'Company Name', 'name' => 'company_name', 'type' => 'text', 'required' => true],
                        ['label' => 'Taxpayer Name', 'name' => 'taxpayer_name', 'type' => 'text', 'required' => true],
                        ['label' => 'TIN Number', 'name' => 'tin_number', 'type' => 'text', 'required' => true],
                        ['label' => 'VAT Number', 'name' => 'vat_number', 'type' => 'text', 'required' => false],
                        ['label' => 'Address', 'name' => 'address', 'type' => 'text', 'required' => true],
                        ['label' => 'House Address', 'name' => 'house_address', 'type' => 'text', 'required' => false],
                        ['label' => 'Street Name', 'name' => 'street_name', 'type' => 'text', 'required' => false],
                        ['label' => 'Town', 'name' => 'town', 'type' => 'text', 'required' => false],
                        ['label' => 'Province', 'name' => 'province', 'type' => 'text', 'required' => false],
                        ['label' => 'Phone Number', 'name' => 'phone_number', 'type' => 'text', 'required' => false],
                        ['label' => 'Email Address', 'name' => 'email_address', 'type' => 'email', 'required' => false],
                    ];
                @endphp

                @foreach($fields as $field)
                    <div class="col-md-6">
                        <label class="form-label text-secondary font-weight-bold">{{ $field['label'] }}</label>
                        <input type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                               class="form-control @error($field['name']) is-invalid @enderror"
                               value="{{ old($field['name'], $clientDetail->{$field['name']}) }}"
                               {{ $field['required'] ? 'required' : '' }}
                               style="background: rgba(255, 255, 255, 0.6); border-radius: 8px; border: 1px solid #dee2e6;">
                        @error($field['name']) <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                @endforeach

            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('client-details.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-save mr-1"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
