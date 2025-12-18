<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{



    public function index()
{
    $sales = Sale::latest()->paginate(15);
    return view('sales.index', compact('sales'));
}


public function show(Sale $sale)
    {
        // Pass the Sale model to the Blade view
        return view('sales.show', compact('sale'));
    }


   public function print(Sale $sale)
{
    // Load the view and pass the sale
    $pdf = Pdf::loadView('sales.print', compact('sale'));
    // Return PDF download or stream to browser
    return $pdf->stream('invoice-'.$sale->invoice_no.'.pdf');
    // Or for download:
    // return $pdf->download('invoice-'.$sale->invoice_no.'.pdf');
}

public function edit(Sale $sale)
{
    return view('sales.edit', compact('sale'));
}

    /**
     * Store a fiscal receipt
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiptType' => 'required|string',
            'receiptCurrency' => 'required|string|max:10',
            'receiptCounter' => 'required|integer',
            'receiptGlobalNo' => 'required|integer',
            'invoiceNo' => 'required|string|unique:receipts,invoice_no',

            // Buyer
            'buyerData.buyerRegisterName' => 'required|string',
            'buyerData.buyerTradeName' => 'nullable|string',
            'buyerData.vatNumber' => 'nullable|string',
            'buyerData.buyerTIN' => 'nullable|string',

            'buyerData.buyerContacts.phoneNo' => 'nullable|string',
            'buyerData.buyerContacts.email' => 'nullable|email',

            'buyerData.buyerAddress.province' => 'nullable|string',
            'buyerData.buyerAddress.city' => 'nullable|string',
            'buyerData.buyerAddress.street' => 'nullable|string',
            'buyerData.buyerAddress.houseNo' => 'nullable|string',
            'buyerData.buyerAddress.district' => 'nullable|string',

            // Receipt body
            'receiptLinesTaxInclusive' => 'required|boolean',
            'receiptLines' => 'required|array|min:1',
            'receiptTaxes' => 'required|array|min:1',
            'receiptPayments' => 'required|array|min:1',

            'receiptTotal' => 'required|numeric',
            'receiptPrintForm' => 'required|string',
            'receiptDate' => 'required|date',

            'username' => 'required|string',
            'usernameSurname' => 'required|string',

            'receiptNotes' => 'nullable|string',
            'creditDebitNote' => 'nullable|array',
        ]);

        DB::beginTransaction();

        try {
            $receipt = Sale::create([
                'receipt_type' => $validated['receiptType'],
                'receipt_currency' => $validated['receiptCurrency'],
                'receipt_counter' => $validated['receiptCounter'],
                'receipt_global_no' => $validated['receiptGlobalNo'],
                'invoice_no' => $validated['invoiceNo'],

                'buyer_register_name' => $validated['buyerData']['buyerRegisterName'],
                'buyer_trade_name' => $validated['buyerData']['buyerTradeName'] ?? null,
                'vat_number' => $validated['buyerData']['vatNumber'] ?? null,
                'buyer_tin' => $validated['buyerData']['buyerTIN'] ?? null,

                'buyer_contacts' => $validated['buyerData']['buyerContacts'] ?? [],
                'buyer_address' => $validated['buyerData']['buyerAddress'] ?? [],
                'credit_debit_note' => $validated['creditDebitNote'] ?? null,

                'receipt_lines_tax_inclusive' => $validated['receiptLinesTaxInclusive'],
                'receipt_lines' => $validated['receiptLines'],
                'receipt_taxes' => $validated['receiptTaxes'],
                'receipt_payments' => $validated['receiptPayments'],

                'receipt_total' => $validated['receiptTotal'],
                'receipt_print_form' => $validated['receiptPrintForm'],
                'receipt_notes' => $validated['receiptNotes'] ?? null,
                'receipt_date' => $validated['receiptDate'],

                'username' => $validated['username'],
                'username_surname' => $validated['usernameSurname'],
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Receipt stored successfully',
                'receipt' => $this->formatForApi($receipt),
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Failed to store receipt',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Return receipt in EXACT ZIMRA format
     */
    
    /**
     * Build API-ready JSON
     */
    private function formatForApi(Receipt $receipt): array
    {
        return [
            'receipt' => [
                'receiptType' => $receipt->receipt_type,
                'receiptCurrency' => $receipt->receipt_currency,
                'receiptCounter' => $receipt->receipt_counter,
                'receiptGlobalNo' => $receipt->receipt_global_no,
                'invoiceNo' => $receipt->invoice_no,

                'buyerData' => [
                    'buyerRegisterName' => $receipt->buyer_register_name,
                    'buyerTradeName' => $receipt->buyer_trade_name,
                    'vatNumber' => $receipt->vat_number,
                    'buyerTIN' => $receipt->buyer_tin,
                    'buyerContacts' => $receipt->buyer_contacts,
                    'buyerAddress' => $receipt->buyer_address,
                ],

                'receiptNotes' => $receipt->receipt_notes,
                'username' => $receipt->username,
                'usernameSurname' => $receipt->username_surname,
                'receiptDate' => $receipt->receipt_date->toIso8601String(),

                'creditDebitNote' => $receipt->credit_debit_note,

                'receiptLinesTaxInclusive' => $receipt->receipt_lines_tax_inclusive,
                'receiptLines' => $receipt->receipt_lines,
                'receiptTaxes' => $receipt->receipt_taxes,
                'receiptPayments' => $receipt->receipt_payments,

                'receiptTotal' => $receipt->receipt_total,
                'receiptPrintForm' => $receipt->receipt_print_form,

                'receiptDeviceSignature' => [
                    'hash' => $receipt->device_hash,
                    'signature' => $receipt->device_signature,
                ],
            ]
        ];
    }
}
