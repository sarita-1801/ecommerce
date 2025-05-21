@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mt-4">Your Cart</h2>

    @if($cartItems->isEmpty())
    <p>Your cart is empty!</p>
@else
    <table class="table">
        <tr>
            <th>Image</th>
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
                $itemTotal = $item->product->cost * $item->quantity; // Use object properties directly
                $totalAmount += $itemTotal;
            @endphp
            <tr>
                <td><img src="{{ asset('storage/' . $item->product->photo) }}" alt="{{ $item->product->name }}" width="100"></td>
                <td>{{ $item->product->name }}</td>
                <td>${{ $item->product->cost }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ $itemTotal }}</td>
                <td>
                    <!-- Edit Button (Triggers Modal) -->
                    <button class="btn btn-warning btn-sm edit-btn" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editModal" 
                            data-id="{{ $item->product->id }}" 
                            data-name="{{ $item->product->name }}" 
                            data-quantity="{{ $item->quantity }}">
                        Edit
                    </button>

                    <!-- Delete Button -->
                    <form action="{{ route('cart.delete', $item->product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        <tr>
            <th colspan="4">Total Amount</th>
            <th>${{ $totalAmount }}</th>
            <th></th>
        </tr>
    </table>
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('product.index') }}" class="btn btn-primary">Continue Shopping</a>
            <a href="{{ route('getCheckOut') }}" class="btn btn-success">Checkout</a>
        </div>
    </div>
@endif

</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Quantity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="product_id" name="product_id">

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery Script to Handle Modal Data -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.edit-btn').click(function () {
            let productId = $(this).data('id');
            let quantity = $(this).data('quantity');
            let actionUrl = "{{ route('cart.update', ':id') }}".replace(':id', productId);

            $('#editForm').attr('action', actionUrl);
            $('#product_id').val(productId);
            $('#quantity').val(quantity);
        });
    });
</script>

@endsection
