<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryCharge;
use App\Models\DeliveryPartner;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\StoreInformation;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();

        foreach ($orders as $order) {
            $products = json_decode($order->products, true);
            foreach ($products as &$product) {
                $productDetails = Product::find($product['id']);
                $product['name'] = $productDetails ? $productDetails->title : 'Unknown';
            }
            $order->products = $products;
        }

        $allCount = Order::count();
        $pendingCount = Order::where('order_status', 'Pending')->count();
        $confirmedCount = Order::where('order_status', 'Confirmed')->count();
        $completedCount = Order::where('order_status', 'Completed')->count();
        $shippedCount = Order::where('order_status', 'Shipped')->count();
        $deliveredCount = Order::where('order_status', 'Delivered')->count();
        $cancelledCount = Order::where('order_status', 'Cancelled')->count();
        $returnedCount = Order::where('order_status', 'Returned')->count();
        $followCount = Order::where('order_status', 'Follow Up')->count();

        $activePartners = DeliveryPartner::where('user_id', auth()->id())
            ->where('status', true)
            ->get();

        return view('backend.order.index', compact(
            'orders',
            'allCount',
            'pendingCount',
            'confirmedCount',
            'shippedCount',
            'deliveredCount',
            'cancelledCount',
            'returnedCount',
            'followCount',
            'completedCount',
            'activePartners'
        ));
    }

    public function create()
    {
        $deliveryZones = DeliveryCharge::where('status', 1)->get();
        return view('backend.order.create', compact('deliveryZones'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_contact' => 'required',
            'customer_name' => 'required',
            'customer_address' => 'required',
            'products' => 'required|array',
            'order_status' => 'required',
            'delivery_zone_id' => 'required|exists:delivery_charges,id',
            'delivery_charge' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'discount_amount' => 'nullable|numeric',
            'total_price' => 'required|numeric',
            'ordered_quantity' => 'required|integer',
        ]);

        // Get delivery zone details
        $deliveryZone = DeliveryCharge::find($validatedData['delivery_zone_id']);

        $order = Order::create([
            'customer_contact' => $validatedData['customer_contact'],
            'customer_name' => $validatedData['customer_name'],
            'customer_address' => $validatedData['customer_address'],
            'products' => json_encode($validatedData['products']),
            'order_status' => $validatedData['order_status'],
            'delivery_zone_id' => $validatedData['delivery_zone_id'],
            'zone_name' => $deliveryZone->zone_name,
            'delivery_charge' => $validatedData['delivery_charge'],
            'subtotal' => $validatedData['subtotal'],
            'discount_amount' => $validatedData['discount_amount'] ?? 0,
            'total_price' => $validatedData['total_price'],
            'ordered_quantity' => $validatedData['ordered_quantity'],
        ]);

        foreach ($validatedData['products'] as $productData) {
            $product = Product::find($productData['id']);

            if ($product) {
                $totalPrice = $product->price * $productData['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productData['id'],
                    'quantity' => $productData['quantity'],
                    'price' => $product->price,
                    'total_price' => $totalPrice,
                ]);

                if ($validatedData['order_status'] == 'completed') {
                    $newStockQuantity = $product->stock_quantity - $productData['quantity'];
                    if ($newStockQuantity >= 0) {
                        $product->stock_quantity = $newStockQuantity;
                        $product->save();

                        Inventory::create([
                            'product_id' => $product->id,
                            'ordered_quantity' => $productData['quantity'],
                            'stock_quantity' => $newStockQuantity,
                            'order_id' => $order->id,
                            'initial_quantity' => $product->initial_quantity,
                        ]);
                    } else {
                        return back()->with('error', 'Not enough stock for product ' . $product->title);
                    }
                }
            }
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order created successfully!');
    }

    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        $products = json_decode($order->products, true);

        return view('backend.order.show', compact('order', 'products'));
    }

    public function edit(string $id)
    {
        $order = Order::findOrFail($id);
        $deliveryZones = DeliveryCharge::where('status', 1)->get();
        return view('backend.order.edit', compact('order', 'deliveryZones'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'customer_contact' => 'required',
            'customer_name' => 'required',
            'customer_address' => 'required',
            'products' => 'required|array',
            'order_status' => 'required',
            'delivery_zone_id' => 'required|exists:delivery_charges,id',
            'delivery_charge' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'discount_amount' => 'nullable|numeric',
            'total_price' => 'required|numeric',
            'ordered_quantity' => 'required|integer',
        ]);

        $order = Order::findOrFail($id);

        // Get delivery zone details
        $deliveryZone = DeliveryCharge::find($validatedData['delivery_zone_id']);

        $wasCompleted = strtolower($order->order_status) === 'completed';
        $isNowCompleted = strtolower($validatedData['order_status']) === 'completed';

        // 1. Restore stock for old products only if old order was completed
        if ($wasCompleted) {
            $previousProducts = json_decode($order->products, true);
            foreach ($previousProducts as $prevProduct) {
                $product = Product::find($prevProduct['id']);
                if ($product) {
                    $product->increment('stock_quantity', $prevProduct['quantity']);
                }
            }
        }

        // 2. Update the order
        $order->update([
            'customer_contact' => $validatedData['customer_contact'],
            'customer_name' => $validatedData['customer_name'],
            'customer_address' => $validatedData['customer_address'],
            'products' => json_encode($validatedData['products']),
            'order_status' => $validatedData['order_status'],
            'delivery_zone_id' => $validatedData['delivery_zone_id'],
            'zone_name' => $deliveryZone->zone_name,
            'delivery_charge' => $validatedData['delivery_charge'],
            'subtotal' => $validatedData['subtotal'],
            'discount_amount' => $validatedData['discount_amount'] ?? 0,
            'total_price' => $validatedData['total_price'],
            'ordered_quantity' => $validatedData['ordered_quantity'],
        ]);

        // 3. Remove old order items
        OrderItem::where('order_id', $order->id)->delete();

        // 4. Insert updated order items and reduce stock if necessary
        foreach ($validatedData['products'] as $productData) {
            $product = Product::find($productData['id']);
            if ($product) {
                // Create Order Item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productData['id'],
                    'quantity' => $productData['quantity'],
                    'price' => $product->price,
                    'total_price' => $product->price * $productData['quantity'],
                ]);

                // Only reduce stock if new status is completed
                if ($isNowCompleted) {
                    $freshProduct = Product::find($product->id);
                    $newStockQuantity = $freshProduct->stock_quantity - $productData['quantity'];

                    if ($newStockQuantity >= 0) {
                        $freshProduct->stock_quantity = $newStockQuantity;
                        $freshProduct->save();

                        Inventory::create([
                            'product_id' => $freshProduct->id,
                            'ordered_quantity' => $productData['quantity'],
                            'stock_quantity' => $newStockQuantity,
                            'order_id' => $order->id,
                            'initial_quantity' => $freshProduct->initial_quantity,
                        ]);
                    } else {
                        return response()->json([
                            'error' => 'Not enough stock for product ' . $product->title
                        ], 422);
                    }
                }
            }
        }

        return response()->json(['success' => true, 'message' => 'Order updated successfully!']);
    }

    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        $products = json_decode($order->products, true);
        foreach ($products as $productData) {
            $product = Product::find($productData['id']);
            if ($product) {
                $product->stock_quantity += $productData['quantity'];
                $product->save();
            }
        }

        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully!');
    }

    public function invoice($id)
    {
        $order = Order::findOrFail($id);
        $products = json_decode($order->products, true);
    
        foreach ($products as &$product) {
            $productDetails = Product::find($product['id']);
            $product['name'] = $productDetails ? $productDetails->title : 'Unknown';
            $product['price'] = $productDetails ? $productDetails->price : 0;
            $product['total'] = $product['price'] * $product['quantity'];
    
            // ✅ Get variant_items from productDetails
            $variationText = [];
    
            if ($productDetails && $productDetails->variant_items) {
                $variantItems = is_array($productDetails->variant_items)
                    ? $productDetails->variant_items
                    : json_decode($productDetails->variant_items, true);
    
                if (is_array($variantItems)) {
                    foreach ($variantItems as $item) {
                        $variant = \App\Models\Variant::find($item['variant_id'] ?? 0);
                        $value = \App\Models\VariantValue::find($item['variant_value_id'] ?? 0);
                        if ($variant && $value) {
                            $variationText[] = $variant->name . ' - ' . $value->name;
                        }
                    }
                }
            }
    
            $product['variation'] = count($variationText) ? implode(', ', $variationText) : 'N/A';
        }
    
        $store = StoreInformation::first();
    
        return view('backend.order.invoice', compact('order', 'products', 'store'));
    }    
}