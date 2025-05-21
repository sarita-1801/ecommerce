@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2>Payment Successful!</h2>
    <p>Amount Paid: Rs. {{ $amount }}</p>
    <p>Transaction ID: {{ $refId }}</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Back to Home</a>
</div>
@endsection
