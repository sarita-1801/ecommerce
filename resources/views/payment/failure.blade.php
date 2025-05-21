@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2 class="text-danger">Payment Failed!</h2>
    <p>Something went wrong. Please try again.</p>
    <a href="{{ url('/') }}" class="btn btn-warning">Back to Home</a>
</div>
@endsection
