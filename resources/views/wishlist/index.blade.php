@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Your Wishlist</h3>

    @if($wishlistItems->isEmpty())
        <p>Your wishlist is empty.</p>
    @else
        <div class="wishlist-items">
            @foreach($wishlistItems as $wishlistItem)
                <div class="wishlist-item">
                    <img src="{{ $wishlistItem->product->photo ? asset('storage/' . $wishlistItem->product->photo) : 'https://via.placeholder.com/150' }}" alt="{{ $wishlistItem->product->name }}">
                    <pre>
                        <h4>{{ $wishlistItem->product->name }}</h4>
                        <p><strong>Price:</strong>${{ number_format($wishlistItem->product->cost, 2) }}</p>
                    </pre>
                    <form action="{{ route('wishlist.remove', $wishlistItem->product) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Remove from Wishlist</button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
   
.wishlist-item {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.wishlist-item img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    margin-right: 15px;
}

.wishlist-item h4 {
    font-size: 20px;
}

.wishlist-item p {
    font-size: 18px;
    color: #888;
}

.wishlist-item button {
    font-size: 14px;
    padding: 5px 10px;
}

</style>
@endsection
