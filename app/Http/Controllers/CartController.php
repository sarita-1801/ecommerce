<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('cart.index', compact('cartItems'));
    }


    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $productId = $request->input('product_id');
        $product = Product::findOrFail($productId); // Use findOrFail for better error handling

        // Check if the cart already exists for the user
        $cartItem = Cart::where('user_id', Auth::id())->where('product_id', $productId)->first();

        if ($cartItem) {
            // Increase quantity if product is already in cart
            $cartItem->increment('quantity');
        } else {
            // Add new item to cart
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => 1,
                'price' => $product->cost, // Store the product price
            ]);
        }

        return redirect()->route('cart.view')->with('success', 'Product added to cart!');
    }

    public function view()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        return view('cart.index', compact('cartItems'));
    }

    

    public function edit($productId)
    {
        $cartItem = Cart::where('user_id', Auth::id())->where('product_id', $productId)->first();

        if (!$cartItem) {
            return redirect()->route('cart.view')->with('error', 'Product not found in cart.');
        }

        return view('cart.edit', compact('cartItem'));
    }

    public function destroy($productId)
    {
        Cart::where('user_id', Auth::id())->where('product_id', $productId)->delete();

        return redirect()->route('cart.view')->with('success', 'Product removed from cart.');
    }

    public function update(Request $request, $productId)
    { 
        $request->validate([
        'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('user_id', Auth::id())->where('product_id', $productId)->first();

        if ($cartItem) {
            if ($request->input('quantity') <= 0) {
                // Remove item if quantity is zero or less
                $this->destroy($productId);
            } else {
                $cartItem->update(['quantity' => $request->input('quantity')]);
                return redirect()->route('cart.view')->with('success', 'Cart updated successfully.');
            }
        }

        return redirect()->route('cart.view')->with('error', 'Product not found in cart.');
    }

    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        $orderTotal = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->cost * $cartItem->quantity;
        });

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $orderTotal,
            'status' => 'pending',
        ]);

        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->cost,
            ]);
        }

        // Clear the cart
        Cart::where('user_id', Auth::id())->delete();

        // Optionally send an invoice email
        // Mail::to(Auth::user()->email)->send(new OrderInvoiceMail($order));

        return redirect()->route('orders.index')->with('success', 'Order placed successfully! Invoice sent to email.');
    }
    // Show orders page
    public function showOrders()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('orders', compact('orders'));
    }
}