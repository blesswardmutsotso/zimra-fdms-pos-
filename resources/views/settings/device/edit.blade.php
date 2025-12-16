@extends('layouts.app')

@section('title', 'Edit Fiscal Device')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-edit text-warning mr-2"></i> Edit Fiscal Device
    </h1>
    <a href="{{ route('device.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Back
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-lg border-0" style="background-color: rgba(255,255,255,0.85);">
            <div class="card-body">

                {{-- SUCCESS MESSAGE --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle mr-1"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- VALIDATION ERRORS --}}
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

                <form action="{{ route('device.update', $device) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- DEVICE INFORMATION --}}
                    <h6 class="text-primary font-weight-bold">Device Information</h6>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Device ID <span class="text-danger">*</span></label>
                            <input type="number"
                                   name="device_id"
                                   class="form-control @error('device_id') is-invalid @enderror"
                                   value="{{ old('device_id', $device->device_id) }}"
                                   required>
                            @error('device_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Model Version</label>
                            <input type="text" class="form-control" value="V1" readonly>
                            <input type="hidden" name="device_model_version" value="V1">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Model Name</label>
                            <input type="text" class="form-control" value="Server" readonly>
                            <input type="hidden" name="device_model_name" value="Server">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Serial Number <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="serial_number"
                                   class="form-control @error('serial_number') is-invalid @enderror"
                                   value="{{ old('serial_number', $device->serial_number) }}"
                                   required>
                            @error('serial_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- TAXPAYER INFORMATION --}}
                    <h6 class="text-primary font-weight-bold mt-4">Taxpayer Information</h6>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Taxpayer Name <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="taxpayer_name"
                                   class="form-control @error('taxpayer_name') is-invalid @enderror"
                                   value="{{ old('taxpayer_name', $device->taxpayer_name) }}"
                                   required>
                            @error('taxpayer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>TIN <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="tin_number"
                                   class="form-control @error('tin_number') is-invalid @enderror"
                                   value="{{ old('tin_number', $device->tin_number) }}"
                                   required>
                            @error('tin_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>VAT Number</label>
                            <input type="text"
                                   name="vat_number"
                                   class="form-control @error('vat_number') is-invalid @enderror"
                                   value="{{ old('vat_number', $device->vat_number) }}">
                            @error('vat_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- ADDRESS --}}
                    <h6 class="text-primary font-weight-bold mt-4">Address</h6>
                    <hr>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label>House No</label>
                            <input type="text" name="house_number" class="form-control"
                                   value="{{ old('house_number', $device->house_number) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Street</label>
                            <input type="text" name="street" class="form-control"
                                   value="{{ old('street', $device->street) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Town <span class="text-danger">*</span></label>
                            <input type="text" name="town" class="form-control @error('town') is-invalid @enderror"
                                   value="{{ old('town', $device->town) }}" required>
                            @error('town')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Province <span class="text-danger">*</span></label>
                            <input type="text" name="province" class="form-control @error('province') is-invalid @enderror"
                                   value="{{ old('province', $device->province) }}" required>
                            @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- SUBMIT BUTTON --}}
                    <button type="submit" class="btn btn-success mt-3">
                        <i class="fas fa-save mr-1"></i> Update Device
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
