@extends('layouts.app')

@section('title', 'Fiscal Devices')

@section('content')
<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-gray-800">
        <i class="fas fa-microchip text-primary mr-2"></i> Fiscal Devices
    </h1>

    <a href="{{ route('device.create') }}" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i> Register Device
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow border-0">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Device ID</th>
                    <th>Model</th>
                    <th>Serial</th>
                    <th>Taxpayer</th>
                    <th>Town</th>
                    <th width="160">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($devices as $device)
                    <tr>
                        <td>{{ $device->device_id }}</td>
                        <td>{{ $device->device_model_name }}</td>
                        <td>{{ $device->serial_number }}</td>
                        <td>{{ $device->taxpayer_name }}</td>
                        <td>{{ $device->town }}</td>
                        <td>
                            <a href="{{ route('device.show', $device) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('device.edit', $device) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('device.destroy', $device) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this device?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No fiscal device registered yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
