@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mt-4">Check Out</h2>
    <div class="row">
        <div class="col-md-8">
            <h4>Buyer information</h4>
            <form method="POST" action="{{ route('checkout.submit') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Order</button>
            </form>
        </div>
        <div class="col-md-4">
            <h4>Your Orders</h4>
            <table class="table">
                <tr>
                    <th>Product</th>
                    <th>Cost</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
                @php
                    $totalAmount = 0;
                @endphp
                @foreach($cartItems as $item) <!-- Use $cartItems here -->
                    @php
                        $itemTotal = $item->product->cost * $item->quantity; // Calculate total for each item
                        $totalAmount += $itemTotal; // Accumulate total amount
                    @endphp
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>${{ number_format($item->product->cost, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($itemTotal, 2) }}</td>
                        <td>
                            <!-- Reorder Button -->
                            <form action="{{ route('cart.add', $item->product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Reorder</button>
                            </form>

                            <!-- Delete Button -->
                            <form action="{{ route('order.delete', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="3">Total Amount</th>
                    <th>${{ number_format($totalAmount, 2) }}</th>
                    <th></th>
                </tr>
            </table>

            <!-- list of products with total amount <br /> -->
            <h5>Select Payment Method</h5>
            <a href="{{route('esewa.pay')}}" class="btn btn-primary">Pay via Esewa</a>
            <a href="" class="btn btn-success">Pay via Fonepay</a>
            <a href="" class="btn btn-danger"> Pay via Paypal</a><br>
        </div>
        
    </div>
</div>
@endsection
