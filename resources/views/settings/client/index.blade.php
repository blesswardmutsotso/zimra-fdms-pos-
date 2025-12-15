@extends('layouts.app')

@section('title', 'Client Details')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user text-muted mr-2"></i> Client Details
    </h1>
</div>

<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <div class="card shadow-sm border-0 bg-white bg-opacity-75 mb-4" style="backdrop-filter: blur(10px);">
            <div class="card-header bg-transparent border-bottom-0">
                <h5 class="mb-0 text-secondary"><i class="fas fa-info-circle mr-2"></i> Client Information</h5>
            </div>
            <div class="card-body p-4">

                @php
                    $client = \App\Models\ClientDetail::first();
                @endphp

                @if($client)
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Company Name:</strong> {{ $client->company_name }}
                        </div>
                        <div class="col-md-6">
                            <strong>Taxpayer Name:</strong> {{ $client->taxpayer_name }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>TIN Number:</strong> {{ $client->tin_number }}
                        </div>
                        <div class="col-md-6">
                            <strong>VAT Number:</strong> {{ $client->vat_number ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Address:</strong> {{ $client->address }}
                        </div>
                        <div class="col-md-6">
                            <strong>House Address:</strong> {{ $client->house_address ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Street Name:</strong> {{ $client->street_name ?? 'N/A' }}
                        </div>
                        <div class="col-md-6">
                            <strong>Town:</strong> {{ $client->town ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Province:</strong> {{ $client->province ?? 'N/A' }}
                        </div>
                        <div class="col-md-6">
                            <strong>Phone Number:</strong> {{ $client->phone_number ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <strong>Email Address:</strong> {{ $client->email_address ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="text-right mt-4">
                        <a href="{{ route('client-details.edit', Crypt::encryptString($client->id)) }}" 
                           class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-edit mr-1"></i> Edit Client Details
                        </a>
                    </div>

                @else
                    <div class="text-center py-5">
                        <h4 class="text-warning mb-3">No Client Details Found</h4>
                        <p class="text-gray-700 mb-4">
                            You haven't added any client details yet.
                        </p>
                        <a href="{{ route('client-details.create') }}" class="btn btn-outline-success btn-lg">
                            <i class="fas fa-plus mr-1"></i> Add Client Details
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection
