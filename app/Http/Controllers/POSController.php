<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class POSController extends Controller
{
    /**
     * Display the POS interface via a hashed URL.
     */
    public function index($hash)
    {
        try {
            // Decrypt the hash
            $value = Crypt::decryptString($hash);

            // Optional: check a fixed value for extra security
            if ($value !== 'pos-access') {
                abort(403, 'Unauthorized access.');
            }
        } catch (\Exception $e) {
            abort(403, 'Invalid access.');
        }

        // Get all products for POS
        $products = Product::orderBy('name')->get();

        return view('pos.index', compact('products'));
    }
}
