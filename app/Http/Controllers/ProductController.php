<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProductController extends Controller
{
   

    /**
     * Display a listing of products.
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category'       => 'required|string|max:255',
            'name'           => 'required|string|max:255',
            'unit'           => 'required|in:single,bulk',
            'description'    => 'nullable|string',
            'selling_price'  => 'required|numeric|min:0',
            'buying_price'   => 'required|numeric|min:0',
            'tax'            => 'required|in:0%,15%,ext',
            'hscode'         => 'nullable|string|max:50',
            'expiry_date'    => 'nullable|date',
        ]);

        // Cast tax to string to handle 'ext' value
        $validated['tax'] = (string) $validated['tax'];

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing a product using hashed ID.
     */
    public function edit($hashedId)
    {
        $id = Crypt::decryptString($hashedId);
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    /**
     * Update an existing product using hashed ID.
     */
    public function update(Request $request, $hashedId)
    {
        $id = Crypt::decryptString($hashedId);
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'category'       => 'required|string|max:255',
            'name'           => 'required|string|max:255',
            'unit'           => 'required|in:single,bulk',
            'description'    => 'nullable|string',
            'selling_price'  => 'required|numeric|min:0',
            'buying_price'   => 'required|numeric|min:0',
            'tax'            => 'required|in:0%,15%,ext',
            'hscode'         => 'nullable|string|max:50',
            'expiry_date'    => 'nullable|date',
        ]);

        // Cast tax to string
        $validated['tax'] = (string) $validated['tax'];

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove a product from storage using hashed ID.
     */
    public function destroy($hashedId)
    {
        $id = Crypt::decryptString($hashedId);
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
