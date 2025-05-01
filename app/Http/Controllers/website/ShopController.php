<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('status', 'active');

        // Apply category filter only if it's not empty
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Apply subcategory filter only if it's not empty
        if ($request->filled('subcategory')) {
            $query->where('subcategory_id', $request->subcategory);
        }

        $products = $query->paginate(12); // Paginate for better performance
        $categories = Category::with('subCategories')->get();

        return view('frontend.shop.shop', compact('products', 'categories'));
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = Category::find($categoryId)?->subCategories ?? [];
        return response()->json($subcategories);
    }

    public function details()
    {
        $products = Product::where('status', 'active')->get();
        return view('frontend.shop-detail.shopDetail', compact('products'));
    }
}
