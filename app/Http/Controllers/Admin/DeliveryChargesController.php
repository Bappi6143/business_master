<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryCharge;
use Illuminate\Support\Str;

class DeliveryChargesController extends Controller
{
    public function index()
    {
        $charges = DeliveryCharge::all();
        return view('backend.delivery_charges.index', compact('charges'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'zone_name' => 'required|unique:delivery_charges,zone_name',
            'delivery_charge' => 'required|numeric|min:0',
            'status' => 'required|boolean',
        ]);

        // Capitalize the first letter of zone_name
        $zone_name = Str::ucfirst($request->zone_name);

        DeliveryCharge::create([
            'zone_name' => $zone_name,
            'delivery_charge' => $request->delivery_charge,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Delivery charge added successfully.');
    }

    public function update(Request $request, DeliveryCharge $delivery_charge)
    {
        $request->validate([
            'zone_name' => 'required|unique:delivery_charges,zone_name,' . $delivery_charge->id,
            'delivery_charge' => 'required|numeric|min:0',
            'status' => 'required|boolean',
        ]);

        // Capitalize the first letter of zone_name
        $zone_name = Str::ucfirst($request->zone_name);

        $delivery_charge->update([
            'zone_name' => $zone_name,
            'delivery_charge' => $request->delivery_charge,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Delivery charge updated successfully.');
    }

    public function destroy(DeliveryCharge $delivery_charge)
    {
        $delivery_charge->delete();
        return redirect()->back()->with('success', 'Delivery charge deleted successfully.');
    }
}
