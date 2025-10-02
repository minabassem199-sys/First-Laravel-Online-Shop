@extends('products.layout.main')

@section('title', 'Product Details')

@section('styles')
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .product-details {
            background-color: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .product-image {
            max-width: 100%;
            border-radius: 15px;
        }
        .product-title {
            font-size: 2.2rem;
            font-weight: bold;
        }
        .product-price {
            font-size: 1.6rem;
            color: #007bff;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .add-to-cart-btn {
            font-size: 1.1rem;
            padding: 12px 28px;
        }
        .additional-info h5 {
            margin-top: 25px;
            margin-bottom: 15px;
        }
    </style>
@endsection

@section('content')
<div class="container my-5">
    <div class="product-details">
        <div class="row">
            {{-- Product Image --}}
            <div class="col-md-6 text-center">
                <img src="{{ asset('storage/' . $product->image) }}" class="product-image" alt="Product Image">
            </div>

            {{-- Product Info --}}
            <div class="col-md-6">
                <h1 class="product-title">{{ $product->name }}</h1>
                <p class="product-price">EGP {{ $product->price }}</p>

                {{-- @if ($product->stock > 0) --}}
                    <form action="{{ route('cart.add') }}" method="POST" class="d-grid gap-2">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-primary btn-lg add-to-cart-btn">
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                    </form>
                {{-- @else
                    <div class="alert alert-warning mt-3">⚠️ This product is currently out of stock.</div>
                @endif --}}

                {{-- Additional Info --}}
                <div class="additional-info">
                    <h5>Additional Details:</h5>
                    {{-- Product Details --}}
                    <p class="lead text-muted">
                         <h6>Product Details</h6>
                        {{ $product->details ?? 'No details available for this product.' }}
                    </p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Category:</strong> {{ $product->category }}</li>
                        <li class="list-group-item"><strong>Brand:</strong> {{ $product->brand }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
