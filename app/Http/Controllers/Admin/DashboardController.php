<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function home()
    {
        // Order stats
        $confirmedOrders = Order::where('order_status', 'confirmed')->count();
        $pendingOrders = Order::where('order_status', 'pending')->count();
        $completedOrders = Order::where('order_status', 'completed')->count();
        $completedOrderAmount = Order::where('order_status', 'completed')->sum('total_price');

        // Total expenses
        $totalExpenses = Expense::sum('amount');

        // Recent orders with product names
        $recentOrders = Order::latest()->take(5)->get();

        foreach ($recentOrders as $order) {
            $products = json_decode($order->products, true);
            $productNames = [];
            $variantSummaries = [];

            foreach ($products as $product) {
                $productDetails = Product::find($product['id']);
                if ($productDetails) {
                    $productNames[] = $productDetails->title;

                    // ✅ Check and decode variant_items from productDetails model
                    $variationText = [];
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

                    $variantSummaries[] = count($variationText)
                        ? implode(', ', $variationText)
                        : 'N/A';
                }
            }

            $order->product_names = implode(', ', $productNames);
            $order->product_variants = implode(' | ', $variantSummaries);
        }

        // Top-selling products
        $topSellingProducts = OrderItem::select(
            'product_id',
            DB::raw('SUM(quantity) as total_units'),
            DB::raw('SUM(total_price) as total_revenue')
        )
            ->groupBy('product_id')
            ->orderByDesc('total_units')
            ->with('product')
            ->take(5)
            ->get();

        // ✅ Add variation summary to each item
        foreach ($topSellingProducts as $item) {
            $variationText = [];

            if ($item->product && $item->product->variant_items) {
                $variantItems = is_array($item->product->variant_items)
                    ? $item->product->variant_items
                    : json_decode($item->product->variant_items, true);

                if (is_array($variantItems)) {
                    foreach ($variantItems as $vi) {
                        $variant = \App\Models\Variant::find($item['variant_id'] ?? 0);
                        $value = \App\Models\VariantValue::find($item['variant_value_id'] ?? 0);
                        if ($variant && $value) {
                            $variationText[] = $variant->name . ' - ' . $value->name;
                        }
                    }
                }
            }

            $item->product_variants = count($variationText)
                ? implode(', ', $variationText)
                : 'N/A';
        }
        // Low stock products
        $lowStockProducts = Product::where('stock_quantity', '<=', 10)
            ->orderBy('stock_quantity')
            ->take(6)
            ->get();

        foreach ($lowStockProducts as $product) {
            $variationText = [];

            $variantItems = is_array($product->variant_items)
                ? $product->variant_items
                : json_decode($product->variant_items, true);

            if (is_array($variantItems)) {
                foreach ($variantItems as $item) {
                    $variant = \App\Models\Variant::find($item['variant_id'] ?? 0);
                    $value = \App\Models\VariantValue::find($item['variant_value_id'] ?? 0);
                    if ($variant && $value) {
                        $variationText[] = $variant->name . ' - ' . $value->name;
                    }
                }
            }

            $product->variant_summary = count($variationText)
                ? implode(', ', $variationText)
                : 'N/A';
        }

        return view('backend.dashboard.dashboard', compact(
            'confirmedOrders',
            'pendingOrders',
            'completedOrders',
            'completedOrderAmount',
            'totalExpenses',
            'recentOrders',
            'topSellingProducts',
            'lowStockProducts'
        ));
    }
}
