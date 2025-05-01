<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 
use App\Models\Checkout;

class CheckoutController extends Controller {
    public function index()
{
    if (session()->has('buy_now_cart')) {
        $cart = session('buy_now_cart', []);
    } else {
        $cart = session('cart', []);
    }

    return view('frontend.checkout.checkout', compact('cart'));
}


public function store(Request $request)
{
    // Log request data (optional for debugging)
    \Log::info('Checkout Request Data:', $request->all());

    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'required|string',
        'cart' => 'required|string', // Cart data must be passed as JSON
        'subtotal' => 'required|numeric',
        'total' => 'required|numeric',
    ]);

    try {
        // Decode cart data
        $cartData = json_decode($request->cart, true);

        if (!$cartData) {
            return back()->with('error', 'Invalid cart data format.');
        }

        // Save order to database
        $checkout = \App\Models\Checkout::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'cart_data' => json_encode($cartData),
            'subtotal' => $request->subtotal,
            'shipping_charge' => 10,
            'total' => $request->total,
        ]);

        // Log success
        \Log::info('Checkout Saved Successfully:', ['checkout' => $checkout]);

        // Session clear: Smart way (buy_now_cart or cart)
        if (session()->has('buy_now_cart')) {
            session()->forget('buy_now_cart'); // ✅ If Buy Now Checkout, remove only buy_now_cart
        } else {
            session()->forget('cart'); // ✅ Otherwise, normal cart checkout, remove cart
        }

        return redirect()->route('home')->with('success', 'Order placed successfully!');
        
    } catch (\Exception $e) {
        // Log error
        \Log::error('Checkout Save Error:', ['error' => $e->getMessage()]);
        return back()->with('error', 'Failed to save order.');
    }
}

}
