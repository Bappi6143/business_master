<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Expense;
use App\Models\Product;

use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $query = Order::selectRaw('DATE(created_at) as date, COUNT(*) as orders_count, SUM(total_price) as total_amount');

        // Apply date filter if provided
        if ($request->has(['start_date', 'end_date']) && $request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $orders = $query->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        return view('backend.sales-report.sales', compact('orders'));
    }


    public function salesDetails(Request $request)
    {
        // Get the date from the query string
        $date = $request->query('date');

        // Retrieve all orders for the specified date
        $orders = Order::with('orderItems')  // Assuming you have orderItems relation if needed
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'desc')
            ->get();

        // Pass the date and orders to the view
        return view('backend.sales-report.details', compact('orders', 'date'));
    }


    public function stock()
    {
        $products = Product::with(['category', 'subcategory'])
            ->select('id', 'title', 'stock_quantity', 'category_id', 'subcategory_id', 'variant_items')
            ->get();
    
        return view('backend.reports.stock', compact('products'));
    }


    public function productperformance()
    {
        $products = \App\Models\OrderItem::select(
            'product_id',
            DB::raw('SUM(quantity) as total_units_sold'),
            DB::raw('SUM(total_price) as total_revenue'),
            DB::raw('AVG(price) as average_price')
        )
            ->groupBy('product_id')
            ->with('product.category') // Eager load related product and its category
            ->orderByDesc('total_units_sold')
            ->get();

        return view('backend.reports.productperformance', compact('products'));
    }


    public function customerreport()
    {
        $customers = Customer::with(['orders' => function ($query) {
            $query->select('customer_contact', 'total_price', 'created_at');
        }])->get();

        foreach ($customers as $customer) {
            $customer->total_orders = $customer->orders->count();
            $customer->total_spent = $customer->orders->sum('total_price');
            $customer->last_order = optional($customer->orders->sortByDesc('created_at')->first())->created_at;
        }

        return view('backend.reports.customerreport', compact('customers'));
    }

    public function financialreport()
    {
        $expenses = Expense::with('category')->orderBy('date', 'desc')->get();
        return view('backend.reports.financialreport', compact('expenses'));
    }
}
