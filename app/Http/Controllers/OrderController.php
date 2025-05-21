<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Show all orders for the authenticated user
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('orders.index', compact('orders'));
    }

    // Show details for a specific order
    public function show($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found.');
        }

        return view('orders.show', compact('order'));
    }

    // Admin: View all orders
    public function allOrders()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    // Admin: Change order status
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|string']);
        
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated.');
    }
}
