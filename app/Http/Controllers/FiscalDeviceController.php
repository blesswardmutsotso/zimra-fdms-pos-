<?php

namespace App\Http\Controllers;

use App\Models\FiscalDevice;
use Illuminate\Http\Request;

class FiscalDeviceController extends Controller
{
    /**
     * Display a listing of the fiscal devices.
     */
    public function index()
    {
        $devices = FiscalDevice::latest()->get();
        return view('settings.device.index', compact('devices'));
    }

    /**
     * Show the form for creating a new fiscal device.
     */
    public function create()
    {
        return view('settings.device.create');
    }

    /**
     * Store a newly created fiscal device.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_id'             => 'required|integer|unique:fiscal_devices,device_id',
            'device_model_name'     => 'required|string|max:255',
            'device_model_version'  => 'required|string|max:255',
            'serial_number'         => 'required|string|max:255|unique:fiscal_devices,serial_number',
            'taxpayer_name'         => 'required|string|max:255',
            'tin_number'            => 'required|string|max:50',
            'vat_number'            => 'nullable|string|max:50',
            'house_number'          => 'nullable|string|max:50',
            'street'                => 'nullable|string|max:255',
            'town'                  => 'required|string|max:255',
            'province'              => 'required|string|max:255',
        ]);

        FiscalDevice::create($validated);

        return redirect()
            ->route('device.index')
            ->with('success', 'Fiscal device registered successfully.');
    }

    /**
     * Display the specified fiscal device.
     */
    public function show(FiscalDevice $device)
    {
        return view('settings.device.show', compact('device'));
    }

    /**
     * Show the form for editing the fiscal device.
     */
    public function edit(FiscalDevice $device)
    {
        return view('settings.device.edit', compact('device'));
    }

    /**
     * Update the specified fiscal device.
     */
    public function update(Request $request, FiscalDevice $device)
    {
        $validated = $request->validate([
            'device_id'             => 'required|integer|unique:fiscal_devices,device_id,' . $device->id,
            'device_model_name'     => 'required|string|max:255',
            'device_model_version'  => 'required|string|max:255',
            'serial_number'         => 'required|string|max:255|unique:fiscal_devices,serial_number,' . $device->id,
            'taxpayer_name'         => 'required|string|max:255',
            'tin_number'            => 'required|string|max:50',
            'vat_number'            => 'nullable|string|max:50',
            'house_number'          => 'nullable|string|max:50',
            'street'                => 'nullable|string|max:255',
            'town'                  => 'required|string|max:255',
            'province'              => 'required|string|max:255',
        ]);

        $device->update($validated);

        return redirect()
            ->route('device.index')
            ->with('success', 'Fiscal device updated successfully.');
    }

    /**
     * Remove the specified fiscal device.
     */
    public function destroy(FiscalDevice $device)
    {
        $device->delete();

        return redirect()
            ->route('device.index')
            ->with('success', 'Fiscal device deleted successfully.');
    }
}
