<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'subcategory'])->orderBy('id', 'desc')->get();
        return view('backend.product.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
                              ->where('id', '!=', $id)
                              ->limit(4)
                              ->get();
        return view('frontend.shop-detail.shopDetail', compact('product','relatedProducts'));
    }
    
    public function create()
    {
        $categories = Category::all();
        $variants = Variant::all();
        return view('backend.product.create', compact('categories', 'variants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'code' => 'required|string|unique:products',
            'initial_quantity' => 'required|integer',
            'category' => 'nullable|exists:categories,id',
            'subcategory' => 'nullable|exists:sub_categories,id',
            'variants.*.variant_id' => 'nullable|exists:variants,id',
            'variants.*.variant_value_id' => 'nullable|exists:variant_values,id',
        ]);

        $title = Str::ucfirst(strtolower($request->title));
        $description = $request->description ? Str::ucfirst(strtolower($request->description)) : '';

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imgName = 'product-image-' . time() . '-' . rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('product-images'), $imgName);
            $imagePath = 'product-images/' . $imgName;
        }

        Product::create([
            'title' => $title,
            'description' => $description,
            'price' => $request->price,
            'code' => $request->code,
            'initial_quantity' => $request->initial_quantity,
            'stock_quantity' => $request->initial_quantity,
            'category_id' => $request->category ?? null,
            'subcategory_id' => $request->subcategory ?? null,
            'variant_items' => json_encode($request->variants),
            'image' => $imagePath,
            'status' => $request->status ?? 'inactive',
        ]);

        return redirect()->route('products.index')->with('message', 'Product created successfully with multiple variants.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $subcategories = $product->category ? $product->category->subcategories : collect();
        $variants = Variant::all();

        return view('backend.product.edit', compact('product', 'categories', 'subcategories', 'variants'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'code' => 'required|string|unique:products,code,' . $id,
            'initial_quantity' => 'required|integer',
            'category' => 'nullable|exists:categories,id',
            'subcategory' => 'nullable|exists:sub_categories,id',
            'variants.*.variant_id' => 'nullable|exists:variants,id',
            'variants.*.variant_value_id' => 'nullable|exists:variant_values,id',
        ]);

        $product = Product::findOrFail($id);
        $soldQuantity = $product->initial_quantity - $product->stock_quantity;

        $newStockQuantity = $request->filled('stock_quantity') ? $request->stock_quantity : ($request->initial_quantity - $soldQuantity);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            if ($product->image && File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }
            $image = $request->file('image');
            $imgName = 'product-image-' . time() . '-' . rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('product-images'), $imgName);
            $imagePath = 'product-images/' . $imgName;
        }

        $product->update([
            'title' => Str::ucfirst(strtolower($request->title)),
            'description' => $request->description ? Str::ucfirst(strtolower($request->description)) : '',
            'price' => $request->price,
            'code' => $request->code,
            'initial_quantity' => $request->initial_quantity,
            'stock_quantity' => $newStockQuantity,
            'category_id' => $request->category,
            'subcategory_id' => $request->subcategory,
            'variant_items' => json_encode($request->variants),
            'image' => $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image && File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }

    public function getVariantValues($variantId)
    {
        $variantValues = VariantValue::where('variant_id', $variantId)->get();
        return response()->json($variantValues);
    }

    // ProductController.php

    public function getProducts()
    {
        $products = Product::select('id', 'title', 'code', 'price', 'stock_quantity')->get();
        return response()->json($products);
    }

}
