@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Your Orders</h3>
    @if($orders->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Placed On</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>${{ number_format($order->total_price, 2) }}</td>
                    <td><span class="badge bg-info">{{ ucfirst($order->status) }}</span></td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No orders found.</p>
    @endif
</div>
@endsection
