<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VariantController extends Controller
{
    public function index()
    {
        $variants = Variant::with('variantValues')->orderBy('id', 'desc')->get();
        return view('backend.variant.index', compact('variants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:variants,name',
            'status' => 'required|boolean',
        ]);

        $inputName = $request->name;
        $formattedName = ctype_lower($inputName)
            ? Str::ucfirst($inputName)
            : $inputName;

        Variant::create([
            'name' => $formattedName,
            'slug' => Str::slug($formattedName),
            'status' => $request->status,
        ]);

        return back()->with('success', 'Variant added successfully!');
    }

    public function edit(Variant $variant)
    {
        $variant->load('variantValues');
        return view('backend.variant.edit', compact('variant'));
    }

    public function update(Request $request, Variant $variant)
    {
        $request->validate([
            'name' => 'required|unique:variants,name,' . $variant->id,
            'status' => 'required|boolean',
        ]);

        $inputName = $request->name;
        $formattedName = ctype_lower($inputName)
            ? Str::ucfirst($inputName)
            : $inputName;

        $variant->update([
            'name' => $formattedName,
            'slug' => Str::slug($formattedName),
            'status' => $request->status,
        ]);

        return redirect()->route('variants.index')->with('success', 'Variant updated successfully!');
    }

    public function destroy(Variant $variant)
    {
        $variant->delete();
        return back()->with('success', 'Variant deleted successfully!');
    }
}
