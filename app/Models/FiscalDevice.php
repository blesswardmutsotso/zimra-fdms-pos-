<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiscalDevice extends Model
{
    protected $table = 'fiscal_devices';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        // Device details
        'device_id',
        'device_model_name',
        'device_model_version',
        'serial_number',

        // Taxpayer details
        'taxpayer_name',
        'tin_number',
        'vat_number',

        // Address details
        'house_number',
        'street',
        'town',
        'province',
    ];
}
