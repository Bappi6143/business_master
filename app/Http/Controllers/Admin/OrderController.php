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
use SteadFast\SteadFastCourierLaravelPackage\Facades\SteadfastCourier;
use Illuminate\Support\Facades\Http;
use App\Helpers\CourierCredentialHelper;

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

        $deliveryZone = DeliveryCharge::find($validatedData['delivery_zone_id']);

        $lastOrderId = Order::max('id') ?? 0; // Get the last order ID
        $invoiceNumber = 'MSBD-ORD-' . str_pad($lastOrderId + 1, 6, '0', STR_PAD_LEFT); 

        $order = Order::create([
            'invoice' => $invoiceNumber,
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

        return redirect()->route('admin.orders.index')->with('success', 'Order created successfully!');
    }

    public function assignDeliveryPartner(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'delivery_partner_id' => 'required|exists:delivery_partners,id',
        ]);

        $order_info = Order::findOrFail($validatedData['order_id']);
       

        $orderData = [
            'invoice' => $order_info->invoice,
            'recipient_name' => $order_info->customer_name,
            'recipient_phone' => $order_info->customer_contact,
            'recipient_address' => $order_info->customer_address,
            'cod_amount' => $order_info->total_price,
            'note' => 'Handle with care'
        ];
        
        // Get credentials from the helper
        $credentials = CourierCredentialHelper::getSteadfastCredentials();
  
        // Construct the API request
        $response = Http::withHeaders([
            'Api-Key'      => $credentials['api_key'],
            'Secret-Key'   => $credentials['secret_key'],
            'Content-Type' => 'application/json',
        ])->post('https://portal.steadfast.com.bd/api/v1/create_order', $orderData);

        // Decode and process response
        $responseData = $response->json();

        if ($response->successful() && isset($responseData['consignment'])) {
            $consignment = $responseData['consignment'];

            $order_info->update([
                'courier_partner'   => 'steadfast',
                'order_status'      => 'shipped',
                'trackingid'        => $consignment['tracking_code'],
                'courier_response'  => json_encode($responseData),
            ]);
        } else {
            $order_info->update([
                'courier_partner'   => 'steadfast',
                'courier_response'  => json_encode($responseData),
            ]);
        }
        
           
            // $redxCredentials = CourierCredentialHelper::getRedxCredentials();
            // $apiToken = $redxCredentials['api_token'];

            // $products = json_decode($order_info->products, true);
            // $parcelDetails = [];
    
            // foreach ($products as $product) {
            //     $parcelDetails[] = [
            //         'name'     => 'productName',
            //         'category' => 'General',
            //         'value'    => (float)$product['price'],
            //     ];
            // }
            
            // $payload = [
            //     "customer_name"          => $order_info->customer_name,
            //     "customer_phone"         => $order_info->customer_contact,
            //     "delivery_area"          => $order_info->zone_name ?? "Dhaka",
            //     "delivery_area_id"       => $order_info->delivery_zone_id ?? 12,
            //     "customer_address"       => $order_info->customer_address,
            //     "merchant_invoice_id"    => $order_info->invoice,
            //     "cash_collection_amount" => $order_info->total_price,
            //     "parcel_weight"          => 500,
            //     "instruction"            => "Handle with care",
            //     "value"                  => 100,
            //     "is_closed_box"          => false,
            //     "pickup_store_id"        => 1,
            //     "parcel_details_json"    => $parcelDetails,
            // ];
   
            // $response = Http::withHeaders([
            //     'API-ACCESS-TOKEN' => 'Bearer ' . $apiToken,
            //     'Content-Type' => 'application/json',
            // ])->post('sandbox.redx.com.bd/v1.0.0-beta/parcel', $payload);
            
            // $responseData = $response->json();

            // if (isset($responseData['tracking_id'])) {
            //     $order_info->update([
            //         'courier_partner'   => 'redx',
            //         'courier_response'  => json_encode($responseData),
            //         'trackingid'        => $responseData['tracking_id'],
            //         'order_status'      => 'shipped',
            //     ]);
            // } else {
            //     $order_info->update([
            //         'courier_partner'   => 'redx',
            //         'courier_response'  => json_encode($responseData),
            //     ]);
            // }
            

        return redirect()->back()->with('success', 'Delivery partner assigned successfully!');
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