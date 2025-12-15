<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class POSController extends Controller
{
    public function index()
    {
        // Get all products for display in POS
        $products = Product::orderBy('name')->get();

        return view('pos.index', compact('products'));
    }
}
