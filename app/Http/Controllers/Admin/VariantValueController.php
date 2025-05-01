<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VariantValue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VariantValueController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:variants,id',
            'name' => 'required|unique:variant_values,name',
            'status' => 'required|boolean',
        ]);

        $inputName = $request->name;
        $formattedName = ctype_lower($inputName)
            ? Str::ucfirst($inputName)
            : $inputName;

        VariantValue::create([
            'variant_id' => $request->variant_id,
            'name' => $formattedName,
            'slug' => Str::slug($formattedName),
            'status' => $request->status,
        ]);

        return back()->with('success', 'Variant value added successfully!');
    }

    public function edit(VariantValue $variantValue)
    {
        return view('backend.variant.edit', compact('variantValue'));
    }

    public function update(Request $request, VariantValue $variantValue)
    {
        $request->validate([
            'name' => 'required|unique:variant_values,name,' . $variantValue->id,
            'status' => 'required|boolean',
        ]);

        $inputName = $request->name;
        $formattedName = ctype_lower($inputName)
            ? Str::ucfirst($inputName)
            : $inputName;

        $variantValue->update([
            'name' => $formattedName,
            'slug' => Str::slug($formattedName),
            'status' => $request->status,
        ]);

        return back()->with('success', 'Variant value updated successfully!');
    }

    public function destroy(VariantValue $variantValue)
    {
        $variantValue->delete();
        return back()->with('success', 'Variant value deleted successfully!');
    }
}
