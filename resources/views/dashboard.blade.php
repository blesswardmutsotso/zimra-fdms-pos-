@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1 class="h3 mb-4 text-gray-800">MyPOS</h1>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Today's Sales</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">$12,450</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Products in Stock</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">1,245</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Customers Today</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">86</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Low Stock Alerts</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">7</div>
            </div>
        </div>
    </div>
</div>
@endsection
