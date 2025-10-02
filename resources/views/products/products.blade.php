@extends('products.layout.main')

@section('styles')
<style>
    body {
        background-color: #f8f9fa;
    }

    .product-card {
        transition: transform 0.2s;
        border-radius: 15px;
        border: none;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .product-card:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }

    .product-card img {
        width: 100%;
        aspect-ratio: 1 / 1;
        object-fit: contain;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        background-color: hsl(0, 0%, 100%);
    }

    .product-card .card-body {
        background-color: #ffffff;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
    }

    .product-price {
        font-size: 1.25rem;
        font-weight: bold;
        color: #adbdce;
    }

    .sort-form {
        max-width: 300px;
        margin: 0 auto 2rem;
    }

    .sort-form label {
        font-weight: bold;
    }
</style>
@endsection

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">All Products</h1>

    {{-- Sort Form --}}
    <form method="GET" action="{{ route('products.index') }}" class="sort-form">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <label for="sort" class="form-label">Sort by:</label>
            </div>
            <div class="col">
                <select name="sort" id="sort" class="form-select" onchange="this.form.submit()">
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                </select>
            </div>
        </div>
    </form>
 <div class="mt-4">
    {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
</div>



    {{-- Products Grid --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        @foreach ($products as $product)
        <div class="col">
            <div class="card h-100 product-card">
                <a href="{{ route('products.details', $product->id) }}">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </a>
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="product-price">EGP {{ $product->price }}</p>
                    <a href="{{ route('products.details', $product->id) }}" class="btn btn-primary">Show Details</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
