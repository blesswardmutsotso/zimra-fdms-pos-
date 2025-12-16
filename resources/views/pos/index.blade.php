@extends('layouts.app')

@section('title', 'Point of Sale')

@php
    use App\Models\ClientDetail;
    $companyName = ClientDetail::value('company_name');
@endphp

@section('content')

<!-- HEADER -->
<div class="mb-4 text-center">
    <h4 class="text-muted mb-1 font-weight-bold">
        {{ $companyName ?: 'Please add company name' }}
    </h4>
    <h1 class="h3 mb-0 text-gray-800">
      
    </h1>
</div>

<br>

<div class="row">

    <!-- PRODUCTS -->
    <div class="col-lg-7">
        <div class="card shadow border-0">
            <div class="card-body">

                <!-- SEARCH -->
                <div class="mb-3">
                    <input type="text" id="productSearch" class="form-control"
                           placeholder="Search product by name or category">
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="thead-light">
                        <tr>
                            <th>Product</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th width="120">Qty</th>
                            <th width="80">Add</th>
                        </tr>
                        </thead>
                        <tbody id="productsTable">
                        @foreach($products as $product)
                            <tr data-name="{{ strtolower($product->name) }}"
                                data-category="{{ strtolower($product->category) }}">
                                <td>{{ $product->name }}</td>
                                <td>{{ ucfirst($product->unit) }}</td>
                                <td>${{ number_format($product->selling_price, 2) }}</td>
                                <td>
                                    <input type="number" min="1" value="1"
                                           class="form-control quantity">
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm add-to-cart"
                                            data-id="{{ $product->id }}"
                                            data-name="{{ $product->name }}"
                                            data-price="{{ $product->selling_price }}">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- CART & PAYMENT -->
    <div class="col-lg-5">
        <div class="card shadow border-0">
            <div class="card-body">

                <h5 class="mb-3">
                    <i class="fas fa-shopping-cart text-success mr-1"></i> Cart
                </h5>

                <ul class="list-group mb-3" id="cart-items">
                    <li class="list-group-item text-muted text-center">
                        No items added yet.
                    </li>
                </ul>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Total:</h5>
                    <h4 class="text-success">$<span id="cart-total">0.00</span></h4>
                </div>

                <!-- PAYMENT METHOD -->
                <div class="mb-3">
                    <label class="font-weight-bold">Payment Method</label>
                    <select id="paymentMethod" class="form-control">
                        <option value="USD CASH" selected>USD CASH</option>
                        <option value="ZWG CASH">ZWG CASH</option>
                        <option value="RAND CASH">RAND CASH</option>
                        <option value="ECO CASH">ECO CASH</option>
                    </select>
                </div>

                <button class="btn btn-success btn-lg btn-block" id="checkout-btn" disabled>
                    <i class="fas fa-credit-card mr-1"></i> Complete Sale
                </button>

            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
let cart = [];

/* UPDATE CART */
function updateCart() {
    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
    const checkoutBtn = document.getElementById('checkout-btn');

    cartItems.innerHTML = '';
    let total = 0;

    if (cart.length === 0) {
        cartItems.innerHTML =
            '<li class="list-group-item text-muted text-center">No items added yet.</li>';
        cartTotal.textContent = '0.00';
        checkoutBtn.disabled = true;
        return;
    }

    cart.forEach(item => {
        const lineTotal = item.price * item.quantity;
        total += lineTotal;

        cartItems.innerHTML += `
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <strong>${item.name}</strong>
                <span>${item.quantity} x $${item.price.toFixed(2)}</span>
                <span>$${lineTotal.toFixed(2)}</span>
            </li>`;
    });

    cartTotal.textContent = total.toFixed(2);
    checkoutBtn.disabled = false;
}

/* ADD TO CART */
document.querySelectorAll('.add-to-cart').forEach(btn => {
    btn.addEventListener('click', function () {
        const row = this.closest('tr');
        const id = this.dataset.id;
        const name = this.dataset.name;
        const price = parseFloat(this.dataset.price);
        const quantity = parseInt(row.querySelector('.quantity').value);

        let existing = cart.find(item => item.id == id);
        existing ? existing.quantity += quantity
                 : cart.push({ id, name, price, quantity });

        updateCart();
    });
});

/* SEARCH */
document.getElementById('productSearch').addEventListener('keyup', function () {
    const search = this.value.toLowerCase();
    document.querySelectorAll('#productsTable tr').forEach(row => {
        row.style.display =
            row.dataset.name.includes(search) ||
            row.dataset.category.includes(search)
            ? '' : 'none';
    });
});

/* CHECKOUT */
document.getElementById('checkout-btn').addEventListener('click', function () {
    const paymentMethod = document.getElementById('paymentMethod').value;
    alert('Sale completed using ' + paymentMethod);
});
</script>
@endpush
