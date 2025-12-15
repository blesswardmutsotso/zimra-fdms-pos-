@extends('layouts.app')

@section('title', 'Add Client Details')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user-plus text-muted mr-2"></i> Add Client Details
    </h1>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm border-0 bg-white bg-opacity-75" style="backdrop-filter: blur(10px);">
            <div class="card-body">

                <!-- Success Alert -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Error / Validation Alerts -->
                @if($errors->any())
                    <div class="alert alert-warning alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('client-details.store') }}" method="POST">
                    @csrf
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label for="company_name">Business Name *</label>
                            <input type="text" name="company_name" 
                                   class="form-control @error('company_name') is-invalid @enderror" 
                                   value="{{ old('company_name') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="taxpayer_name">Taxpayer Name *</label>
                            <input type="text" name="taxpayer_name" 
                                   class="form-control @error('taxpayer_name') is-invalid @enderror" 
                                   value="{{ old('taxpayer_name') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tin_number">TIN Number *</label>
                            <input type="text" name="tin_number" 
                                   class="form-control @error('tin_number') is-invalid @enderror" 
                                   value="{{ old('tin_number') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="vat_number">VAT Number</label>
                            <input type="text" name="vat_number" 
                                   class="form-control @error('vat_number') is-invalid @enderror" 
                                   value="{{ old('vat_number') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="address">Address *</label>
                            <input type="text" name="address" 
                                   class="form-control @error('address') is-invalid @enderror" 
                                   value="{{ old('address') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="house_address">House Address</label>
                            <input type="text" name="house_address" 
                                   class="form-control @error('house_address') is-invalid @enderror" 
                                   value="{{ old('house_address') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="street_name">Street Name</label>
                            <input type="text" name="street_name" 
                                   class="form-control @error('street_name') is-invalid @enderror" 
                                   value="{{ old('street_name') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="town">Town</label>
                            <input type="text" name="town" 
                                   class="form-control @error('town') is-invalid @enderror" 
                                   value="{{ old('town') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="province">Province</label>
                            <input type="text" name="province" 
                                   class="form-control @error('province') is-invalid @enderror" 
                                   value="{{ old('province') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" name="phone_number" 
                                   class="form-control @error('phone_number') is-invalid @enderror" 
                                   value="{{ old('phone_number') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email_address">Email Address</label>
                            <input type="email" name="email_address" 
                                   class="form-control @error('email_address') is-invalid @enderror" 
                                   value="{{ old('email_address') }}">
                        </div>

                    </div>

                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-save mr-1"></i> Save
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
