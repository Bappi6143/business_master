<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreInformation;
use Illuminate\Support\Str;

class StoreInformationController extends Controller
{
    public function index()
    {
        $storeInfo = StoreInformation::first();
        return view('backend.store_information.index', compact('storeInfo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string',
            'email' => 'nullable|email',
            'website' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        StoreInformation::create([
            'name' => Str::ucfirst($request->name),
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'website' => $request->website,
            'address' => $request->address ? Str::ucfirst($request->address) : null,
        ]);

        return redirect()->back()->with('success', 'Store information saved successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string',
            'email' => 'required|email',
            'website' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $storeInfo = StoreInformation::findOrFail($id);

        $storeInfo->update([
            'name' => Str::ucfirst($request->name),
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'website' => $request->website,
            'address' => $request->address ? Str::ucfirst($request->address) : null,
        ]);

        return redirect()->back()->with('success', 'Store information updated successfully!');
    }
}
