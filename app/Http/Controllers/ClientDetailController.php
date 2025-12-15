<?php

namespace App\Http\Controllers;

use App\Models\ClientDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ClientDetailController extends Controller
{
    /**
     * Display client details (single record).
     */
    public function index()
    {
return view('settings.client.index');
    }

    /**
     * Show the form for creating client details.
     */
    public function create()
    {
        return view('settings.client.create');
    }

    /**
     * Store newly created client details.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name'   => 'required|string|max:255',
            'taxpayer_name'  => 'required|string|max:255',
            'tin_number'     => 'required|string|max:50',
            'vat_number'     => 'nullable|string|max:50',
            'address'        => 'required|string|max:255',
            'house_address'  => 'nullable|string|max:255',
            'street_name'    => 'nullable|string|max:255',
            'town'           => 'nullable|string|max:255',
            'province'       => 'nullable|string|max:255',
            'phone_number'   => 'nullable|string|max:30',
            'email_address'  => 'nullable|email|max:255',
        ]);

        ClientDetail::create($validated);

        return redirect()
            ->route('client-details.index')
            ->with('success', 'Client details saved successfully.');
    }

    /**
     * Show the form for editing client details (hashed ID).
     */
    public function edit(string $hashedId)
    {
        $id = Crypt::decryptString($hashedId);
        $clientDetail = ClientDetail::findOrFail($id);

        return view('settings.client.edit', compact('clientDetail'));
    }

    /**
     * Update client details.
     */
    public function update(Request $request, string $hashedId)
    {
        $id = Crypt::decryptString($hashedId);
        $clientDetail = ClientDetail::findOrFail($id);

        $validated = $request->validate([
            'company_name'   => 'required|string|max:255',
            'taxpayer_name'  => 'required|string|max:255',
            'tin_number'     => 'required|string|max:50',
            'vat_number'     => 'nullable|string|max:50',
            'address'        => 'required|string|max:255',
            'house_address'  => 'nullable|string|max:255',
            'street_name'    => 'nullable|string|max:255',
            'town'           => 'nullable|string|max:255',
            'province'       => 'nullable|string|max:255',
            'phone_number'   => 'nullable|string|max:30',
            'email_address'  => 'nullable|email|max:255',
        ]);

        $clientDetail->update($validated);

        return redirect()
            ->route('client-details.index')
            ->with('success', 'Client details updated successfully.');
    }

    /**
     * Remove client details (optional).
     */
    public function destroy(string $hashedId)
    {
        $id = Crypt::decryptString($hashedId);
        ClientDetail::findOrFail($id)->delete();

        return redirect()
            ->route('settings.client.index')
            ->with('success', 'Client details removed.');
    }
}
