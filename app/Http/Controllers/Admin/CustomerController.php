<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('backend.customers.index', compact('customers'));
    }

    public function getCustomers()
    {
        $customers = Customer::select('id', 'name', 'phone', 'address')->get();
        return response()->json($customers);
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:11|unique:customers,phone',
            'address' => 'required|string',
        ]);

        // Capitalize first letter of name and address
        $validated['name'] = Str::ucfirst(strtolower($validated['name']));
        $validated['address'] = Str::ucfirst(strtolower($validated['address']));

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Customer added successfully.');
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(Customer $customer)
    {
        return view('backend.customers.edit', compact('customer'));
    }


    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, Customer $customer)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|digits:11|unique:customers,phone,' . $customer->id,
        'address' => 'required|string',
    ]);

    $customer->update([
        'name' => Str::ucfirst(strtolower($request->name)),
        'phone' => $request->phone,
        'address' => Str::ucfirst(strtolower($request->address)),
    ]);

    return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
}


    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
