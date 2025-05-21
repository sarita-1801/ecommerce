<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Add product to wishlist
    public function addToWishlist(Product $product)
    {
        $user = Auth::user();
        
        // Check if product is already in the user's wishlist
        $wishlistItem = Wishlist::where('user_id', $user->id)
                                ->where('product_id', $product->id)
                                ->first();

        if (!$wishlistItem) {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }

        return redirect()->route('wishlist.index');
    }

    // Remove product from wishlist
    public function removeFromWishlist(Product $product)
    {
        $user = Auth::user();

        // Find the wishlist item and delete it
        $wishlistItem = Wishlist::where('user_id', $user->id)
                                ->where('product_id', $product->id)
                                ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
        }

        return redirect()->route('wishlist.index');
    }

    // Show user's wishlist
    public function index()
    {
        $user = Auth::user();
        $wishlistItems = Wishlist::where('user_id', $user->id)->get();

        return view('wishlist.index', compact('wishlistItems'));
    }
}
