<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-Shop') }}</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> 
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    @stack('styles') 

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(['resources/js/search.js'])
</head>
<body>
@if(session('status'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold text-dark" href="{{ url('/') }}">
                    {{ config('app.name', 'E-Shop') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">  
                        
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        <div class="social-icons">
                            <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-facebook-f fa-lg"></i>
                            </a>
                            <a href="https://www.linkedin.com/" target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-linkedin fa-lg"></i>
                            </a>
                            <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-instagram fa-lg"></i>
                            </a>
                        </div>
                        <style>
                            .social-icons a {
                                margin-right: 18px; 
                            }
                        </style>
                       
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <header class="header">
            <div class="container d-flex justify-content-between align-items-center py-2"> 
                <nav>
                    <ul class="nav-links">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownShop" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownShop">
                            <li><a class="dropdown-item" href="{{ route('about') }}">About</a></li>
                            <li><a class="dropdown-item" href="{{route('getManageCategory')}}">Manage Category</a></li>
                            <li><a class="dropdown-item" href="{{ route('getAddProduct') }}">Add Product</a></li>
                        </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{route('product.index')}}">Shop</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('contact')}}">Contact</a></li>
                    </ul>
                </nav>
                <!--Search Bar-->
                <div class="nav-icons d-flex align-items-center">
                    <a href="{{ route('search.index') }}" class="nav-link">
                        <i class="fa fa-search" style="font-size: 24px;"></i>
                    </a>
                                    
                     <!-- Wishlist Icon with Count -->
                        <a href="{{ route('wishlist.index') }}" class="nav-link">
                            <i class="fa fa-heart  fs-4" style="font-size: 24px;"></i>
                            @if(auth()->check())
                                @php
                                    $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
                                @endphp
                                @if($wishlistCount > 0)
                                    <span class="badge wishlist-badge text-danger">{{ $wishlistCount }}</span>
                                @endif
                            @endif
                        </a>

                    <a href="{{route('cart.view')}}"><i class="fa fa-shopping-cart" style="font-size:24px; color:white;"></i></a>
                    <!-- Dropdown Menu -->
                    
                    <div class="dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user" style="font-size:24px; color:white;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" style="min-width: 200px;">
                            @guest
                                @if (Route::has('login'))
                                    <li>
                                        <a class="dropdown-item" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif
                                @if (Route::has('register'))
                                <li>
                                    <a class="dropdown-item" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                                @endif
                            @else
                            <li>
                                <span class="dropdown-item-text">{{ Auth::user()->name }}</span>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        
        
        <main class="py-3">
            @yield('content')
        </main>

        <footer class="footer">
            <div class="container">
                <p>&copy; 2024 E-Shop. All rights reserved.</p>
            </div>
        </footer>
    </div>
    
</body>
</html>
