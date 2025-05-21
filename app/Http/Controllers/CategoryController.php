<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // Ensure only admins can access these methods
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('home')->with('error', 'You are not authorized to access this page.');
            }
            return $next($request);
        });
    }

    public function getManageCategory(){
        $categories = Category::all();
        return view('admin.category.manage', compact('categories'));
    }

    public function postAddCategory(Request $request)
    {
        $title=$request->input('title');
        $detail=$request->input('details');

        $Category=New Category();
        $Category->title=$title;
        $Category->details=$detail;
       
        $Category->save();

        return redirect()->back()->with('success', 'Category added successfully!');
    }

     // Update an existing category
     public function update(Request $request, $id)
     {
         $request->validate([
             'title' => 'required|string|max:255',
             'details' => 'required|string',
         ]);
 
         $category = Category::findOrFail($id);
         $category->update([
             'title' => $request->title,
             'details' => $request->details,
         ]);
 
         return redirect()->back()->with('success', 'Category updated successfully!');
     }
 
     // Delete a category
     public function destroy($id)
     {
         $category = Category::findOrFail($id);
         $category->delete();
 
         return redirect()->back()->with('success', 'Category deleted successfully!');
     }
   

   

}
