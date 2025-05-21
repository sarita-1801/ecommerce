@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
</head>

<header class="text-white py-4">
    <div class="container">
        <h1 class="text-center">About Us</h1>
    </div>
</header>

<main class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-4 text-center">Welcome to {{ config('app.name') }}</h2>
                <p>At {{ config('app.name') }}, we are passionate about bringing you the best products and services. Founded in 2024, we have dedicated ourselves to creating a seamless shopping experience for our customers.</p>

                <h3>Our Mission</h3>
                <p>To deliver high-quality products at affordable prices while ensuring excellent customer service. Your satisfaction is our top priority!</p>

                <h3>Our Values</h3>
                <ul class="point">
                    <li>Quality and Integrity</li>
                    <li>Customer Satisfaction</li>
                    <li>Innovation</li>
                    <li>Sustainability</li>
                </ul>

                <h3>Meet Our Team</h3>
                <p>Our dedicated team works tirelessly to bring you the best experience. From product sourcing to customer support, we ensure every detail is managed with care.</p>

                <div class="text-center mt-4">
                    <a href="{{ url('/') }}" class="btn btn-primary">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection
