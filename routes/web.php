<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WishlistController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index1'])->name('home1');
Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store']);
Route::get('/search', [SearchController::class, 'index'])->name('search.index');

Auth::routes();

// **Customer Panel Routes** (Requires Authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Product Viewing
    Route::get('/all-products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');

    // Cart & Checkout
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.delete');

    Route::get('/checkout', [CheckoutController::class, 'getCheckOut'])->name('getCheckOut');
    Route::post('/checkout', [CheckoutController::class, 'submitOrder'])->name('checkout.submit');
    
    //Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');

    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->middleware('auth')->name('reviews.store');

    // eSewa Payments
    Route::get('/esewa/pay', [PaymentController::class, 'paideSewa'])->name('esewa.pay');
    Route::get('/esewa/success', [PaymentController::class, 'esewaSuccess'])->name('esewa.success');
    Route::get('/esewa/failure', [PaymentController::class, 'esewaFailure'])->name('esewa.failure');
});

// **Admin Panel Routes** (Requires Authentication)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');

    // Category Management
    Route::get('/category/manage', [CategoryController::class, 'getManageCategory'])->name('getManageCategory');
    Route::post('/category/add', [CategoryController::class, 'postAddCategory'])->name('postAddCategory');
    Route::put('/category/{id}/update', [CategoryController::class, 'update'])->name('updateCategory');
    Route::delete('/category/{id}/delete', [CategoryController::class, 'destroy'])->name('deleteCategory');

    // Product Management
    Route::get('/product/add', [ProductController::class, 'getAddProduct'])->name('getAddProduct');
    Route::post('/product/add', [ProductController::class, 'postAddProduct'])->name('postAddProduct');
    Route::put('/product/{id}', [ProductController::class, 'update'])->name('updateProduct');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('deleteProduct');

    // Order Management
    Route::get('/admin/orders', [OrderController::class, 'allOrders'])->name('admin.orders.index');
    Route::put('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
});