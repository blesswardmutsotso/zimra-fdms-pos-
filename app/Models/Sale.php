<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'receipts';

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

    /**
     * Normalize receipt lines for the view.
     */
    public function getFormattedReceiptLinesAttribute()
    {
        return collect($this->receipt_lines ?? [])->map(function ($line, $index) {
            return [
                'receiptLineNo' => $line['receiptLineNo'] ?? $index + 1,
                'receiptLineName' => $line['receiptLineName'] ?? $line['description'] ?? '—',
                'receiptLinePrice' => $line['receiptLinePrice'] ?? $line['unit_price'] ?? 0,
                'receiptLineQuantity' => $line['receiptLineQuantity'] ?? $line['quantity'] ?? 0,
                'receiptLineTotal' => $line['receiptLineTotal'] ?? $line['line_total'] ?? 0,
                'taxPercent' => $line['taxPercent'] ?? 0,
            ];
        })->toArray();
    }

    /**
     * Normalize taxes for the view.
     */
    public function getFormattedReceiptTaxesAttribute()
    {
        return collect($this->receipt_taxes ?? [])->map(function ($tax) {
            return [
                'taxCode' => $tax['taxCode'] ?? '—',
                'taxPercent' => $tax['taxPercent'] ?? 0,
                'taxAmount' => $tax['taxAmount'] ?? 0,
                'salesAmountWithTax' => $tax['salesAmountWithTax'] ?? 0,
            ];
        })->toArray();
    }

    /**
     * Normalize payments for the view.
     */
    public function getFormattedReceiptPaymentsAttribute()
    {
        return collect($this->receipt_payments ?? [])->map(function ($payment) {
            return [
                'moneyTypeCode' => $payment['moneyTypeCode'] ?? $payment['method'] ?? '—',
                'paymentAmount' => $payment['paymentAmount'] ?? $payment['amount'] ?? 0,
            ];
        })->toArray();
    }
}
