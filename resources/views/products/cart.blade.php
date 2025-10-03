@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('styles')
<style>
    .cart-container {
        margin-top: 60px;
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .cart-table th, .cart-table td {
        vertical-align: middle;
    }
    .cart-table th {
        background-color: #343a40;
        color: #fff;
    }
    .cart-total {
        font-size: 1.2rem;
        font-weight: bold;
        color: #0d6efd;
    }
    .empty-cart {
        padding: 40px;
        background-color: #f8f9fa;
        border-radius: 10px;
        font-size: 1.1rem;
    }
</style>
@endsection

@section('content')
<div class="container cart-container">
    <h2 class="mb-4 text-center text-primary">🛒 Your Shopping Cart</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if(!empty($cart) && count($cart) > 0)
        <table class="table table-bordered cart-table">
            <thead>
                <tr>
                    <th>📦 Product</th>
                    <th>💰 Price</th>
                    <th>🔢 Quantity</th>
                    <th>🧮 Subtotal</th>
                    <th>🗑️ Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $details)
                    @php
                        $subtotal = $details['price'] * $details['quantity'];
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $details['name'] }}</td>
                        <td>{{ number_format($details['price'], 2) }} EGP</td>
                        <td>{{ $details['quantity'] }}</td>
                        <td>{{ number_format($subtotal, 2) }} EGP</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i> Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end cart-total">Total:</td>
                    <td colspan="2" class="cart-total">{{ number_format($total, 2) }} EGP</td>
                </tr>
            </tfoot>
        </table>
        <form action="{{ route('orders.store') }}" method="POST">
    @csrf
    <input type="hidden" name="total" value="{{ $cartTotal }}">
    <button type="submit" class="btn btn-success">
        إتمام الطلب (Cash on Delivery)
    </button>
</form>

    @else
        <div class="empty-cart text-center">
            <p>🛍️ Your cart is empty. <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">Add products</a> to start shopping!</p>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
@endsection
