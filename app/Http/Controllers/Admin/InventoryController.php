<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{

    public function index()
    {
        $products = Product::select('id', 'title', 'stock_quantity')->get();
        return view('backend.inventory.index', compact('products'));
    }
   
}
