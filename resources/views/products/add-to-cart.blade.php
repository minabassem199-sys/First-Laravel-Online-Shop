{{-- resources/views/products/add-to-cart.blade.php --}}

@extends('layouts.app') {{-- تأكد من أن هذا هو اسم ملف الـ layout الصحيح عندك --}}

@section('content')
<div class="container" style="max-width: 600px; margin-top: 50px;">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title text-center">🛒 Add a Product to Your Cart</h4>
        </div>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="product_id" class="form-label fw-bold">Select Product</label>
                    <select name="product_id" class="form-select" required>
                        <option value="" disabled selected>-- Choose a product --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->name }} ({{ number_format($product->price, 2) }} EGP)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="quantity" class="form-label fw-bold">Quantity</label>
                    <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
            </form>
        </div>
    </div>
</div>
@endsection
