@extends('layouts.app')

@section('title', 'Register Fiscal Device')

@section('content')
<h1 class="h3 mb-4 text-gray-800">
    <i class="fas fa-plus-circle text-primary mr-2"></i> Register Fiscal Device
</h1>

@include('settings.device.partial.form', [
    'route' => route('device.store'),
    'method' => 'POST',
    'device' => null,
    'button' => 'Register Device'
])
@endsection
