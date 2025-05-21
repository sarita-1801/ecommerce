@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Order Details</h3>
    <p><strong>Order ID:</strong> #{{ $order->id }}</p>
    <p><strong>Status:</strong> <span class="badge bg-info">{{ ucfirst($order->status) }}</span></p>
    <p><strong>Total Price:</strong> ${{ number_format($order->total_price, 2) }}</p>
    <p><strong>Placed On:</strong> {{ $order->created_at->format('d M Y') }}</p>

    <h4>Items</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
</div>
@endsection
