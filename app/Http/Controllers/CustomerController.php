<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created customer.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'          => 'required|string|max:255',
                'vat_number'    => 'nullable|string|max:10|unique:customers,vat_number',
                'tin_number'    => 'nullable|string|max:10|unique:customers,tin_number',
                'house_number'  => 'nullable|string|max:50',
                'street'        => 'nullable|string|max:255',
                'town'          => 'required|string|max:255',
                'province'      => 'required|string|max:255',
            ]);

            Customer::create($validated);

            return redirect()
                ->route('customers.index')
                ->with('success', 'Customer created successfully.');
        } catch (QueryException $e) {
            return back()->withInput()->with('error', 'Error creating customer: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified customer.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the customer.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer.
     */
    public function update(Request $request, Customer $customer)
    {
        try {
            $validated = $request->validate([
                'name'          => 'required|string|max:255',
                'vat_number'    => 'nullable|string|max:10|unique:customers,vat_number,' . $customer->id,
                'tin_number'    => 'nullable|string|max:10|unique:customers,tin_number,' . $customer->id,
                'house_number'  => 'nullable|string|max:50',
                'street'        => 'nullable|string|max:255',
                'town'          => 'required|string|max:255',
                'province'      => 'required|string|max:255',
            ]);

            $customer->update($validated);

            return redirect()
                ->route('customers.index')
                ->with('success', 'Customer updated successfully.');
        } catch (QueryException $e) {
            return back()->withInput()->with('error', 'Error updating customer: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified customer.
     */
    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();

            return redirect()
                ->route('customers.index')
                ->with('success', 'Customer deleted successfully.');
        } catch (QueryException $e) {
            return back()->with('error', 'Error deleting customer: ' . $e->getMessage());
        }
    }
}
