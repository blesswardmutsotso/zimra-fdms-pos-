<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Allow mass assignment for these fields
    protected $fillable = [
        'category',
        'name',
        'unit',
        'description',
        'selling_price',
        'buying_price',
        'tax',
        'hscode',
        'expiry_date',
    ];

    // Optional: cast expiry_date to a date object
    protected $casts = [
        'expiry_date' => 'date',
        'selling_price' => 'decimal:2',
        'buying_price' => 'decimal:2',
    ];
}
