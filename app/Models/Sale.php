<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'receipts'; // ✅ points to receipts table

    protected $fillable = [
        'receipt_type',
        'receipt_currency',
        'receipt_counter',
        'receipt_global_no',
        'invoice_no',
        'buyer_register_name',
        'buyer_trade_name',
        'vat_number',
        'buyer_tin',
        'buyer_contacts',
        'buyer_address',
        'credit_debit_note',
        'receipt_lines_tax_inclusive',
        'receipt_lines',
        'receipt_taxes',
        'receipt_payments',
        'receipt_total',
        'receipt_print_form',
        'username',
        'username_surname',
        'receipt_notes',
        'receipt_date',
        'device_hash',
        'device_signature',
    ];

    protected $casts = [
        'buyer_contacts' => 'array',
        'buyer_address' => 'array',
        'credit_debit_note' => 'array',
        'receipt_lines' => 'array',
        'receipt_taxes' => 'array',
        'receipt_payments' => 'array',
        'receipt_lines_tax_inclusive' => 'boolean',
        'receipt_date' => 'datetime',
    ];
}
