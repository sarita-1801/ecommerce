@extends('layouts.app')


@section('content')
<div class="container" id="dataContainer">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/carousel.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    @endpush
    
    <section class="hero">
        <div class="container">
            <div id="carouselExampleDark" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="1000">
                        <img src="{{ asset('img/image1.jpg') }}" class="d-block w-80" alt="Welcome to E-Shop">
                            <h2>Welcome to E-Shop</h2>
                            <p>Discover the best products at unbeatable prices.</p>
                            <a href="{{ route('product.index') }}" class="btn btn-primary">Shop Now</a>
                    </div>
                    <div class="carousel-item" data-bs-interval="1000">
                        <img src="{{ asset('img/cutedress.jpg') }}" class="d-block w-80" alt="New Collection">
                            <h1>New Collection</h1>
                            <p>Explore our latest arrivals today!</p>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('img/images.jpg') }}" class="d-block w-80" alt="Third Slide">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>   
        </div>
    </section>

    <section class="products">
        <div class="container">
            <h3>Top Products</h3>
            <div class="row g-4">
                @foreach($recentProducts as $product)
                    <div class="col-md-4">
                        <div class="product-card">
                            <a href="{{ route('product.show', $product->id) }}">
                                <img src="{{ $product->photo ? asset('storage/' . $product->photo) : 'https://via.placeholder.com/150' }}" class="img-fluid" alt="{{ $product->name }}">
                                <h4>{{ $product->name }}</h4>
                                <p>${{ number_format($product->cost, 2) }}</p>
                            </a>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                @endforeach
                @if($recentProducts->isEmpty())
                    <div class="col-12 text-center">
                        <p class="text-muted">No products available.</p>
                    </div>
                @endif
            </div>

            @if($recentProducts->count() > 3)
                <div class="see-more">
                    <a href="{{ route('product.index') }}" class="btn btn-outline-primary">SEE MORE</a>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection
