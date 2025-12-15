<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientDetail extends Model
{
    // Mass assignable fields
    protected $fillable = [
        'company_name',
        'taxpayer_name',
        'tin_number',
        'vat_number',
        'address',
        'house_address',
        'street_name',
        'town',
        'province',
        'phone_number',
        'email_address',
    ];
}
