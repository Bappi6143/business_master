<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function index()
    {
        return view('backend.domain.index');
    }
}
