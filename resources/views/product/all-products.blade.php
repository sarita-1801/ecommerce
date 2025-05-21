@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mt-4">All Products</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('storage/' . $product->photo) }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->detail }}</p>
                    <p class="card-text"><strong>Cost:</strong> ${{ $product->cost }}</p>
                    <p class="card-text"><strong>Category:</strong> {{ $product->category ? $product->category->title : $product->cat_id }}</p>
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-outline-info">Add to Cart</button>
                    </form>
                    <form action="{{ route('wishlist.add', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-info ">Add to Wishlist</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

             
@endsection