@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-box-open text-primary mr-2"></i> Add Product
    </h1>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-lg border-0" style="background-color: rgba(255,255,255,0.85);">
            <div class="card-body">

                <!-- Success Alert -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Error Alert -->
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="row">

                        <!-- Category -->
                        <div class="col-md-6 mb-3">
                            <label for="category">Category *</label>
                            <input type="text" name="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category') }}" required>
                        </div>

                        <!-- Product Name -->
                        <div class="col-md-6 mb-3">
                            <label for="name">Product Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        </div>

                        <!-- Unit -->
                        <div class="col-md-6 mb-3">
                            <label for="unit">Unit *</label>
                            <select name="unit" class="form-control @error('unit') is-invalid @enderror" required>
                                <option value="">-- Select Unit --</option>
                                <option value="single" {{ old('unit') == 'single' ? 'selected' : '' }}>Single</option>
                                <option value="bulk" {{ old('unit') == 'bulk' ? 'selected' : '' }}>Bulk</option>
                            </select>
                        </div>

                        <!-- Tax -->
                        <div class="col-md-6 mb-3">
                            <label for="tax">Tax *</label>
                            <select name="tax" class="form-control @error('tax') is-invalid @enderror" required>
                                <option value="">-- Select Tax --</option>
                                <option value="0%" {{ old('tax') === '0%' ? 'selected' : '' }}>0%</option>
                                <option value="15%" {{ old('tax') === '15%' ? 'selected' : '' }}>15%</option>
                                <option value="ext" {{ old('tax') === 'ext' ? 'selected' : '' }}>Exempt</option>
                            </select>
                        </div>

                        <!-- Selling Price -->
                        <div class="col-md-6 mb-3">
                            <label for="selling_price">Selling Price *</label>
                            <input type="number" step="0.01" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror" value="{{ old('selling_price') }}" required>
                        </div>

                        <!-- Buying Price -->
                        <div class="col-md-6 mb-3">
                            <label for="buying_price">Buying Price *</label>
                            <input type="number" step="0.01" name="buying_price" class="form-control @error('buying_price') is-invalid @enderror" value="{{ old('buying_price') }}" required>
                        </div>

                        <!-- HS Code -->
                        <div class="col-md-6 mb-3">
                            <label for="hscode">HS Code</label>
                            <input type="text" name="hscode" class="form-control @error('hscode') is-invalid @enderror" value="{{ old('hscode') }}">
                        </div>

                        <!-- Expiry Date -->
                        <div class="col-md-6 mb-3">
                            <label for="expiry_date">Expiry Date</label>
                            <input type="date" name="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" value="{{ old('expiry_date') }}">
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        </div>

                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary mt-2">
                            <i class="fas fa-save mr-1"></i> Add Product
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
