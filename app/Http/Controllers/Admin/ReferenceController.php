<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reference;
use Illuminate\Support\Facades\Auth;

class ReferenceController extends Controller
{
    public function index()
    {
        $references = Reference::all();

        // Pass references to the view
        return view('backend.reference.index', compact('references'));
    }
    public function store(Request $request)
{
    $request->validate([
        'customer_id' => 'required|string',
        'reference_name' => 'required|array',
        'reference_name.*' => 'required|string',
        'phone_number' => 'required|array',
        'phone_number.*' => 'required|string',
    ]);

    foreach ($request->reference_name as $index => $name) {
        Reference::create([
            'customer_id' => $request->customer_id,
            'reference_name' => $name,
            'phone_number' => $request->phone_number[$index],
        ]);
    }

    return redirect()->back()->with('success', 'References added successfully!');
}

}
