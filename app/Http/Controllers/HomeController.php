<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index() {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
       // Fetch recent products (e.g., 6 most recent products)
       $recentProducts = Product::latest()->take(6)->get();

       // Pass the recent products to the home view
       return view('home', compact('recentProducts'));
    }
    
    public function adminDashboard() {
        {
            $totalProducts = Product::count();
            $totalOrders = Order::count();
            $totalCategories = Category::count();
            $totalUsers = User::count();
    
            return view('admin.dashboard', compact('totalProducts', 'totalOrders', 'totalCategories', 'totalUsers'));
        }
    }
}
