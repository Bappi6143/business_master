<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SubCategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $inputName = $request->name;
        $formattedName = ctype_lower($inputName)
            ? Str::ucfirst($inputName)
            : $inputName;

        // Check if same subcategory name exists under same category (case-insensitive)
        $exists = SubCategory::where('category_id', $request->category_id)
            ->whereRaw('LOWER(name) = ?', [strtolower($formattedName)])
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'This subcategory already exists under this category.']);
        }

        SubCategory::create([
            'category_id' => $request->category_id,
            'name' => $formattedName,
            'slug' => Str::slug($formattedName),
            'status' => $request->status,
        ]);

        return back()->with('success', 'Subcategory added successfully!');
    }

    public function edit(SubCategory $subcategory)
    {
        return view('backend.category.edit', compact('subcategory'));
    }

    public function update(Request $request, SubCategory $subcategory)
    {
        $request->validate([
            'name' => 'required|unique:sub_categories,name,' . $subcategory->id,
            'status' => 'required|boolean',
        ]);

        $inputName = $request->name;
        $formattedName = ctype_lower($inputName)
            ? Str::ucfirst($inputName)
            : $inputName;

        $subcategory->update([
            'name' => $formattedName,
            'slug' => Str::slug($formattedName),
            'status' => $request->status,
        ]);

        return back()->with('success', 'Subcategory updated successfully!');
    }

    public function destroy(SubCategory $subcategory)
    {
        $subcategory->delete();
        return back()->with('success', 'Subcategory deleted successfully!');
    }
}
