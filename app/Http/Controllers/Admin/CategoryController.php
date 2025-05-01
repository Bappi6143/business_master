<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('subCategories')->orderBy('id', 'desc')->get();
        $totalCategories = $categories->count();
        $totalSubCategories = $categories->sum(fn($cat) => $cat->subCategories->count());

        return view('backend.category.index', compact('categories', 'totalCategories', 'totalSubCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'status' => 'required|boolean',
        ]);

        $inputName = $request->name;
        // Only ucfirst if all lowercase
        $formattedName = ctype_lower($inputName)
            ? Str::ucfirst($inputName)
            : $inputName;

        Category::create([
            'name' => $formattedName,
            'slug' => Str::slug($formattedName),
            'status' => $request->status,
        ]);

        return back()->with('success', 'Category added successfully!');
    }

    public function edit(Category $category)
    {
        $category->load('subCategories');
        return view('backend.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
            'status' => 'required|boolean',
        ]);

        $inputName = $request->name;
        // Only ucfirst if all lowercase
        $formattedName = ctype_lower($inputName)
            ? Str::ucfirst($inputName)
            : $inputName;

        $category->update([
            'name' => $formattedName,
            'slug' => Str::slug($formattedName),
            'status' => $request->status,
        ]);

        return back()->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted successfully!');
    }
}
