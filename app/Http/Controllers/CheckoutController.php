<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
   // Show the checkout page with cart items
   public function getCheckOut()
   {
       // Get cart items from session
       $cart = session()->get('cart', []);
       $cartItems = $this->getCartItems($cart);
       $totalAmount = $this->calculateTotalAmount($cartItems);

       foreach ($cart as $item) {
           $product = Product::find($item['product_id']);
           if ($product) {
               $cartItems[] = [
                   'product' => $product->name,
                   'quantity' => $item['quantity'],
                   'total_price' => $item['quantity'] * $product->cost
               ];
               $totalAmount += $item['quantity'] * $product->cost;
           }
       }

       $orders = Auth::check() ? Order::where('user_id', Auth::id())->get() : collect();

       return view('admin.checkout', compact('cartItems', 'orders', 'totalAmount'));
   }

   // Handle the order submission
   public function submitOrder(Request $request)
   {
       // Validate the request
       $validated = $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'payment_method' => 'required|string', // Ensure payment method is selected
    ]);

    // Process the cart data
    $cart = session()->get('cart', []);
    $orderItems = $this->getCartItems($cart);
    $orderTotal = $this->calculateTotalAmount($orderItems);

    foreach ($cart as $item) {
        $product = Product::find($item['product_id']);
        if ($product) {
            $orderTotal += $item['quantity'] * $product->price;
            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->cost,
            ];
        }
    }

     // Store the total amount in the session for payment processing
     Session::put('total_amount', $orderTotal); // Store total amount for payment

    // Create the order in the database
    $order = Order::create([
        'user_id' => Auth::id(), // Assuming authentication is used
        'total_price' => $orderTotal,
        'status' => 'pending',
        'payment_method' => $validated['payment_method'], // Store selected payment method
        'name' => $validated['name'],
        'address' => $validated['address'],
        'phone' => $validated['phone'],
        'email' => $validated['email']
    ]);

    // Clear the cart after order submission
    session()->forget('cart');

    // Redirect to a success page (order confirmation, for example)
    return redirect()->route('order.success')->with('success', 'Order placed successfully!');
   }

   // Helper method to get cart items and their total prices
   private function getCartItems($cart)
   {
       $cartItems = [];

       foreach ($cart as $item) {
           $product = Product::find($item['product_id']);
           if ($product) {
               $cartItems[] = [
                   'product' => $product,
                   'quantity' => $item['quantity'],
                   'total_price' => $item['quantity'] * $product->cost,
               ];
           }
       }

       return $cartItems;
   }

   // Helper method to calculate the total amount
   private function calculateTotalAmount($cartItems)
   {
       return array_sum(array_column($cartItems, 'total_price'));
   }

}
