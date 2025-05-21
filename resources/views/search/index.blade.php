@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Search Products</h2>

    <!-- Search Form -->
    <form action="{{ route('search.index') }}" method="GET" class="input-group mb-4">
        <input type="text" name="query" class="form-control" placeholder="Search products or categories" value="{{ request('query') }}" required>
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
    </form>

    <!-- Display Search Results -->
    @if(isset($products) && count($products) > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('storage/' . $product->photo) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">${{ $product->cost }}</p>
                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-outline-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        @if(request('query'))
            <p class="text-danger">No products found for "{{ request('query') }}".</p>
        @endif
    @endif
</div>
@endsection
