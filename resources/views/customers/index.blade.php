@extends('layouts.app')

@section('title', 'Customers')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-users text-primary mr-2"></i> Customers</h1>
    <a href="{{ route('customers.create') }}" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i> Add Customer
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        @if($customers->count())
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Town</th>
                        <th>Province</th>
                        <th>VAT Number</th>
                        <th>TIN Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $index => $customer)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->town }}</td>
                        <td>{{ $customer->province }}</td>
                        <td>{{ $customer->vat_number }}</td>
                        <td>{{ $customer->tin_number }}</td>
                        <td>
                            <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this customer?');">
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
            <h4 class="text-warning mb-3">No Customers Found</h4>
            <a href="{{ route('customers.create') }}" class="btn btn-primary btn-lg"><i class="fas fa-plus mr-1"></i> Add Customer</a>
        </div>
        @endif
    </div>
</div>
@endsection
