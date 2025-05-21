<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin' && in_array($request->route()->getName(), ['getAddProduct', 'postAddProduct', 'updateProduct', 'deleteProduct'])) {
                return redirect()->route('home')->with('error', 'You are not authorized to access this page.');
            }
            return $next($request);
        });
    }

     //Display the homepage with recently added products
     public function index1()
     {
         $recentProducts = Product::latest()->take(3)->get(); // Fetch the 4 most recent products
         return view('home', compact('recentProducts'));
     }

     public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'LIKE', "%$query%")
            ->orWhere('category', 'LIKE', "%$query%")
            ->get();

        return response()->json($products);
    }
     

    public function getAddProduct()
    {
        $categories = Category::all(); // Fetch all categories
        $products = Product::with('category')->get();
        return view('admin.product.add', compact('products', 'categories'));
    }

    public function postAddProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'required|string',
            'cost' => 'required|numeric|min:0',
            'category' => 'required|exists:categories,id',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle the uploaded photo
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('img', 'public');
            $finalPhotoPath = 'img/' . basename($photoPath);
            Storage::move("public/$photoPath", "public/$finalPhotoPath");
            $photoPath = $finalPhotoPath;
        }
        
        // Save the product to the database
        $product = new \App\Models\Product();
        $product->name = $request->input('name');
        $product->detail = $request->input('detail');
        $product->cost = $request->input('cost');
        $product->cat_id = $request->input('category');
        $product->photo = $photoPath;
        $product->user_id = Auth::id();
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product added successfully!');
    }

    public function index()
    {
        $products = Product::with('category')->get(); // Fetch products with their categories
        return view('admin.product.all-products', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id); // Fetch product by ID or throw 404
        return view('admin.product.show', compact('product'));
    }

      // Update an existing product
      public function update(Request $request, $id)
      {
          $validatedData = $request->validate([
              'name' => 'required|string|max:255',
              'detail' => 'required|string',
              'cost' => 'required|numeric',
              'category' => 'required|exists:categories,id',
              'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
          ]);
  
          $product = Product::findOrFail($id);
  
          if ($request->hasFile('photo')) {
            // Delete old photo
            if ($product->photo && Storage::exists("public/{$product->photo}")) {
                Storage::delete("public/{$product->photo}");
            }

            // Save new photo
            $photoPath = $request->file('photo')->store('img', 'public');
            $finalPhotoPath = 'img/' . basename($photoPath);
            Storage::move("public/$photoPath", "public/$finalPhotoPath");
            $product->photo = $finalPhotoPath;
        }
  
          $product->update([
              'name' => $validatedData['name'],
              'detail' => $validatedData['detail'],
              'cost' => $validatedData['cost'],
              'cat_id' => $validatedData['category'],
          ]);
  
          return redirect()->back()->with('success', 'Product updated successfully!');
      }
  
      // Delete a product
      public function destroy($id)
      {
          $product = Product::findOrFail($id);
            // Delete the photo
            if ($product->photo && Storage::exists("public/{$product->photo}")) {
                Storage::delete("public/{$product->photo}");
            }
          $product->delete();
  
          return redirect()->back()->with('success', 'Product deleted successfully!');
      }
  
}