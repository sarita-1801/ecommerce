@extends('layouts.app')

@section('content')
<div class="product-details">
    <div class="row align-items-center">
        <!-- Product Image -->
        <div class="col-md-6 text-center">
            <img src="{{ $product->photo ? asset('storage/' . $product->photo) : 'https://via.placeholder.com/150' }}" alt="{{ $product->name }}" style="width: 300px; height: 300px;" />
        </div>
        <!-- Product Details -->
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <p><strong>Price:</strong>${{ number_format($product->cost, 2) }}</p>
            <p><strong>Category:</strong> {{ $product->category ? $product->category->title : $product->cat_id }}</p>
            
            <p><strong>Details:</strong> {{ $product->detail }}</p>

             <!-- Average Rating -->
             <p><strong>Rating:</strong> ⭐ {{ number_format($product->averageRating(), 1) }}/5 ({{ $product->reviews->count() }} Reviews)</p>
            
             <div class="d-flex gap-2">
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

 <!-- Reviews Section -->
 <div class="mt-5">
        <h4>Customer Reviews</h4>
        
        @foreach($product->reviews as $review)
            <div class="border p-3 mb-2">
                <strong>{{ $review->user->name }}</strong> ⭐ {{ $review->rating }}/5
                <p>{{ $review->comment }}</p>
            </div>
        @endforeach

        @auth
            <!-- Submit Review -->
            <h5>Add a Review</h5>
            <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                @csrf
                <div class="mb-2">
                    <label for="rating">Rating:</label>
                    <select name="rating" class="form-select" required>
                        <option value="5">⭐ 5</option>
                        <option value="4">⭐ 4</option>
                        <option value="3">⭐ 3</option>
                        <option value="2">⭐ 2</option>
                        <option value="1">⭐ 1</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label for="comment">Review:</label>
                    <textarea name="comment" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        @else
            <p><a href="{{ route('login') }}">Login</a> to write a review.</p>
        @endauth
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
