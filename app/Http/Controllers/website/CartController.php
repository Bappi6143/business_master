<?php
namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        // Retrieve cart data from session
        $cart = session()->get('cart', []);
        return view('frontend.cart.cart', compact('cart'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // Check if product already exists in cart
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'title' => $product->title,
                'price' => $product->price,
                'quantity' => 1,
                'image' => asset('frontend-assets/img/product-1.jpg'), // Replace with actual product image
            ];
        }

        session()->put('cart', $cart);

        // Calculate total quantity
        $totalQuantity = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'message' => 'Product added to cart successfully!',
            'cart' => $cart,
            'totalQuantity' => $totalQuantity
        ]);
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
    
        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
    
        // Calculate new subtotal
        $subtotal = $cart[$request->id]['price'] * $cart[$request->id]['quantity'];
    
        // Calculate total quantity & total price
        $totalQuantity = array_sum(array_column($cart, 'quantity'));
        $totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
    
        return response()->json([
            'subtotal' => number_format($subtotal, 2),
            'totalQuantity' => $totalQuantity,
            'totalPrice' => number_format($totalPrice, 2)
        ]);
    }

    public function orderNow($id)
{
    $product = Product::findOrFail($id);
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id]['quantity'] += 1;
    } else {
        $cart[$id] = [
            'id' => $product->id,
            'title' => $product->title,
            'price' => $product->price,
            'quantity' => 1,
            'image' => $product->image ?? asset('frontend-assets/img/default.png'),
        ];
    }

    session()->put('cart', $cart);

    return redirect()->route('cart')->with('success', 'Product added to cart and redirected to cart page.');
}

public function removeFromCart($id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    return redirect()->route('cart')->with('success', 'Product removed from cart.');
}

public function buyNow(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $buyNowCart = [
        $id => [
            'id' => $product->id,
            'title' => $product->title,
            'price' => $product->price,
            'quantity' => 1,
            'image' => $product->image ?? asset('frontend-assets/img/default.png'),
        ]
    ];

    session()->put('buy_now_cart', $buyNowCart); // ✅ নতুন Session শুধু Buy Now এর জন্য

    return response()->json([
        'success' => true,
        'message' => 'Product ready for direct checkout!',
    ]);
}

}
