@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user-edit text-warning mr-2"></i> Edit Customer
    </h1>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Back to Customers
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-lg border-0">
            <div class="card-body">

                {{-- Success Alert --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle mr-1"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Validation Errors --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <h6 class="font-weight-bold mb-2">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Please fix the following errors:
                        </h6>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('customers.update', $customer) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>House No</label>
                            <input type="text" name="house_number" class="form-control" value="{{ old('house_number', $customer->house_number) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Street</label>
                            <input type="text" name="street" class="form-control" value="{{ old('street', $customer->street) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Town <span class="text-danger">*</span></label>
                            <input type="text" name="town" class="form-control" value="{{ old('town', $customer->town) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Province <span class="text-danger">*</span></label>
                            <input type="text" name="province" class="form-control" value="{{ old('province', $customer->province) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>VAT Number</label>
                            <input type="text" name="vat_number" class="form-control" value="{{ old('vat_number', $customer->vat_number) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>TIN Number</label>
                            <input type="text" name="tin_number" class="form-control" value="{{ old('tin_number', $customer->tin_number) }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-1"></i> Update Customer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
