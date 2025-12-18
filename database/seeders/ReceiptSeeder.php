<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;
use Carbon\Carbon;

class ReceiptSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Clear table to avoid duplicate invoice numbers
        Sale::truncate();

        $receiptLines = [
            [
                'receiptLineType' => 'Sale',
                'receiptLineNo' => 1,
                'receiptLineHSCode' => '1000',
                'receiptLineName' => 'Laptop',
                'receiptLinePrice' => 800,
                'receiptLineQuantity' => 1,
                'receiptLineTotal' => 800,
                'taxCode' => 'VAT',
                'taxPercent' => 15,
                'taxID' => 1,
            ],
            [
                'receiptLineType' => 'Sale',
                'receiptLineNo' => 2,
                'receiptLineHSCode' => '1001',
                'receiptLineName' => 'Printer',
                'receiptLinePrice' => 300,
                'receiptLineQuantity' => 1,
                'receiptLineTotal' => 300,
                'taxCode' => 'VAT',
                'taxPercent' => 15,
                'taxID' => 1,
            ],
            [
                'receiptLineType' => 'Sale',
                'receiptLineNo' => 3,
                'receiptLineHSCode' => '1002',
                'receiptLineName' => 'Keyboard',
                'receiptLinePrice' => 50,
                'receiptLineQuantity' => 2,
                'receiptLineTotal' => 100,
                'taxCode' => 'VAT',
                'taxPercent' => 15,
                'taxID' => 1,
            ],
            [
                'receiptLineType' => 'Sale',
                'receiptLineNo' => 4,
                'receiptLineHSCode' => '1003',
                'receiptLineName' => 'Mouse',
                'receiptLinePrice' => 25,
                'receiptLineQuantity' => 2,
                'receiptLineTotal' => 50,
                'taxCode' => 'VAT',
                'taxPercent' => 15,
                'taxID' => 1,
            ],
            [
                'receiptLineType' => 'Sale',
                'receiptLineNo' => 5,
                'receiptLineHSCode' => '1004',
                'receiptLineName' => 'USB Flash Disk',
                'receiptLinePrice' => 20,
                'receiptLineQuantity' => 3,
                'receiptLineTotal' => 60,
                'taxCode' => 'VAT',
                'taxPercent' => 15,
                'taxID' => 1,
            ],
        ];

        $subTotal   = collect($receiptLines)->sum('receiptLineTotal'); // 1310
        $totalTax   = $subTotal * 0.15;                                // 196.50
        $grandTotal = $subTotal + $totalTax;                           // 1506.50

        Sale::create([
            'receipt_type' => 'FiscalInvoice',
            'receipt_currency' => 'USD',
            'receipt_counter' => 1,
            'receipt_global_no' => 1001,
            'invoice_no' => 'INV-001',

            'buyer_register_name' => 'ABC Holdings',
            'buyer_trade_name' => 'ABC Store',
            'vat_number' => 'VAT123456',
            'buyer_tin' => 'TIN987654',

            'buyer_contacts' => [
                'phoneNo' => '0770000000',
                'email' => 'abc@store.com',
            ],

            'buyer_address' => [
                'province' => 'Harare',
                'city' => 'Harare',
                'street' => 'Samora Machel',
                'houseNo' => '12A',
                'district' => 'CBD',
            ],

            'credit_debit_note' => null,
            'receipt_lines_tax_inclusive' => false,

            'receipt_lines' => $receiptLines,

            'receipt_taxes' => [
                [
                    'taxCode' => 'VAT',
                    'taxPercent' => 15,
                    'taxID' => 1,
                    'taxAmount' => $totalTax,
                    'salesAmountWithTax' => $grandTotal,
                ]
            ],

            'receipt_payments' => [
                [
                    'moneyTypeCode' => 'Cash',
                    'paymentAmount' => $grandTotal,
                ]
            ],

            'receipt_total' => $grandTotal,
            'receipt_print_form' => 'Receipt48',

            'username' => 'admin',
            'username_surname' => 'user',
            'receipt_notes' => 'Invoice with 5 products',
            'receipt_date' => Carbon::now(),
        ]);
    }
}
