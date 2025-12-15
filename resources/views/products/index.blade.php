@extends('layouts.app')

@section('title', 'View Products')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-boxes text-primary mr-2"></i> Products
    </h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i> Add Product
    </a>
</div>

<div class="card shadow-lg border-transparent">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($products->count())
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Unit</th>
                            <th>Selling Price</th>
                            <th>Buying Price</th>
                            <th>Tax</th>
                            <th>Expiry Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->category }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ ucfirst($product->unit) }}</td>
                                <td>{{ number_format($product->selling_price, 2) }}</td>
                                <td>{{ number_format($product->buying_price, 2) }}</td>
                                <td>{{ $product->tax }}</td>
                                <td>{{ $product->expiry_date ? $product->expiry_date->format('Y-m-d') : 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('products.edit', Crypt::encryptString($product->id)) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('products.destroy', Crypt::encryptString($product->id)) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <h4 class="text-warning mb-3">No Products Found</h4>
                <p class="text-gray-700 mb-4">Please add products to your inventory.</p>
                <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus mr-1"></i> Add Product
                </a>
            </div>
        @endif
    </div>
</div>

@endsection
