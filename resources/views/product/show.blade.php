@extends('layouts.app')

@section('content')
<div class="product-details">
    <div class="row align-items-center">
        <!-- Product Image -->
        <div class="col-md-6 text-center">
            <img src="{{ $product->photo ? asset('storage/' . $product->photo) : 'https://via.placeholder.com/150' }}" alt="{{ $product->name }}" style="width: 300px; height: 300px;" />
        </div>
        <!-- Product Details -->
        <div class="col-md-2">
            <h2>{{ $product->name }}</h2>
            <p><strong>Price:</strong>${{ number_format($product->cost, 2) }}</p>
            <p><strong>Category:</strong> {{ $product->category ? $product->category->title : $product->cat_id }}</p>
            
            <p><strong>Details:</strong> {{ $product->detail }}</p>
            <div class="button">
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                </form>
                <form action="{{ route('wishlist.add', $product) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Add to Wishlist</button>
                </form>
            </div>
            
        </div>
    </div>
</div>

<style>
    .product-details{
        text-align: center;
    }

    h2{
        font-weight: bold;
    }

    .btn{
        border: 1px solid black;
    }
    
    .button{
        display: flexbox;
        text-align: center;
    }
</style>
@endsection
