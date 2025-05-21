@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

    <div class="container mt-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <!-- Left Section -->
        <div class="col-md-5 bg-light p-4 shadow">
            <h3>Get in Touch</h3>
            <p><strong>Location:</strong> Srijanachowk, Pokhara</p>
            <p><strong>Phone:</strong>9806595220</p>
            <h5>Follow Us:</h5>
            <ul class="list-unstyled">
            <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-facebook-f fa-lg"></i>
                            </a>
                            <a href="https://www.linkedin.com/" target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-linkedin fa-lg"></i>
                            </a>
                            <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-instagram fa-lg"></i>
                            </a>
            </ul>
        </div>

        <!-- Right Section -->
        <div class="col-md-7 p-4 shadow">
            <h3>Contact Us</h3>
            <form action="{{ route('contact') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
    </div>
</div>


<style>
    /* General Styles */
    body {
        font-family: 'Arial', sans-serif;
    }

    .contact-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 50px;
    }

    .contact-left, .contact-right {
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background: #fff;
        flex: 1;
        min-width: 300px;
    }

    .contact-left {
        background: linear-gradient(135deg, #f3f4f6, #ffffff);
        position: relative;
    }

    .contact-left h3 {
        font-size: 24px;
        margin-bottom: 25px;
        color: #333;
    }

    .contact-left p {
        font-size: 16px;
        margin-bottom: 20px;
    }

    .contact-left ul {
        list-style: none;
        padding: 0;
    }

    .contact-left ul li {
        display: inline-block;
        margin-right: 10px;
    }

    .contact-left ul li a {
        font-size: 24px;
        color: #007bff;
        text-decoration: none;
        transition: transform 0.3s ease, color 0.3s ease;
    }

    .contact-left ul li a:hover {
        color: #0056b3;
        transform: scale(1.2);
    }

    .contact-right h3 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }

    .form-control {
        border: 2px solid #ddd;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    button[type="submit"] {
        background: #007bff;
        color: #fff;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        transition: background 0.3s ease, transform 0.2s ease;
    }

    button[type="submit"]:hover {
        background: #0056b3;
        transform: scale(1.05);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .contact-container {
            flex-direction: column;
        }
    }
</style>
@endsection