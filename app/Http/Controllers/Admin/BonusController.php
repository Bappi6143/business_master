<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reference;

class BonusController extends Controller
{
    public function index()
    {
        $groupedBonus = Reference::all()->groupBy('customer_id');

        return view('backend.bonus.index', compact('groupedBonus'));
    }
}
