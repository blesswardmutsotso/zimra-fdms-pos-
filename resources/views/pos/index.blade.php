@extends('layouts.app')

@section('title', 'POS Interface')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><i class="fas fa-cash-register mr-2"></i> POS Interface</h1>
        <button class="btn btn-primary btn-lg">Checkout</button>
    </div>

    <div class="row">
        <!-- Products list -->
        <div class="col-lg-8">
            <div class="row g-3">
                @forelse($products as $product)
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text mb-1">Price: ${{ number_format($product->selling_price, 2) }}</p>
                                <p class="card-text mb-1">Unit: {{ ucfirst($product->unit) }}</p>
                                <button class="btn btn-success btn-block mt-2 add-to-cart" data-id="{{ $product->id }}">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            No products available. Please add products to your inventory.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Cart -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Cart</h5>
                </div>
                <div class="card-body" id="cart-items">
                    <p class="text-muted">No items in cart.</p>
                </div>
                <div class="card-footer">
                    <h5>Total: $<span id="cart-total">0.00</span></h5>
                    <button class="btn btn-success btn-lg w-100 mt-2">Checkout</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const cart = [];
    let total = 0;

    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            const card = button.closest('.card');
            const name = card.querySelector('.card-title').textContent;
            const price = parseFloat(card.querySelector('.card-text').textContent.replace('Price: $',''));

            cart.push({id, name, price});
            total += price;

            updateCart();
        });
    });

    function updateCart() {
        const cartContainer = document.getElementById('cart-items');
        cartContainer.innerHTML = '';
        cart.forEach(item => {
            const div = document.createElement('div');
            div.textContent = `${item.name} - $${item.price.toFixed(2)}`;
            cartContainer.appendChild(div);
        });
        document.getElementById('cart-total').textContent = total.toFixed(2);
    }
</script>
@endpush
