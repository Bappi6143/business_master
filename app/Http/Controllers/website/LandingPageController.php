<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'active')->get(); 
        return view('frontend.home.index', compact('products'));
    }
}
