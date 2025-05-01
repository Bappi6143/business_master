<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checkout;

class WebsiteCheackOutController extends Controller
{
    public function index()
    {
        // Fetch checkout data from the database
        $checkouts = Checkout::latest()->get();

        // Ensure cart_data is always an array
        foreach ($checkouts as $checkout) {
            $checkout->cart_data = is_array($checkout->cart_data) ? $checkout->cart_data : json_decode($checkout->cart_data, true);
        }

        return view('backend.check-out.index', compact('checkouts'));
    }
    public function destroy($id)
    {
        $checkout = Checkout::findOrFail($id);
        $checkout->delete();
        return redirect()->route('checkout.index')->with('success', 'Checkout deleted successfully.');
    }
}
