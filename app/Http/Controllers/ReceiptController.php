<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Exception;

class ReceiptController extends Controller
{
    /* =======================
     * LIST & VIEW
     * ======================= */
    public function index()
    {
        $allSales = Sale::latest()->get();

        $receipts = $allSales->where('receipt_type', 'FISCAL_INVOICE');
        $creditNotes = $allSales->where('receipt_type', 'FISCAL_CREDIT_NOTE');
        $debitNotes = $allSales->where('receipt_type', 'FISCAL_DEBIT_NOTE');

        return view('sales.index', compact('receipts', 'creditNotes', 'debitNotes'));
    }

    public function show(Sale $sale)
    {
        return view('sales.show', compact('sale'));
    }

    /* =======================
     * PRINT PDF
     * ======================= */
    public function print(Sale $sale)
    {
        $pdf = Pdf::loadView('sales.print', compact('sale'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('invoice-' . $sale->invoice_no . '.pdf');
    }

    /* =======================
     * STORE ORIGINAL INVOICE
     * ======================= */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|integer',
            'cart.*.name' => 'required|string',
            'cart.*.price' => 'required|numeric|min:0',
            'cart.*.quantity' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|max:20',
            'currency' => 'required|string|max:10',
        ]);

        try {
            return DB::transaction(function () use ($validated) {

                $receiptCounter = DB::table('receipts')->lockForUpdate()->max('receipt_counter');
                $receiptCounter = ($receiptCounter ?? 0) + 1;

                $receiptGlobalNo = DB::table('receipts')->lockForUpdate()->max('receipt_global_no');
                $receiptGlobalNo = ($receiptGlobalNo ?? 0) + 1;

                $invoiceNo = 'INV-' . now()->format('Ymd') . '-' . str_pad($receiptCounter, 5, '0', STR_PAD_LEFT);

                $receiptLines = collect($validated['cart'])->map(function ($item) {
                    return [
                        'product_id' => $item['id'],
                        'description' => $item['name'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['price'],
                        'line_total' => $item['price'] * $item['quantity'],
                    ];
                })->toArray();

                $receiptPayments = [
                    [
                        'method' => $validated['payment_method'],
                        'amount' => $validated['total'],
                        'currency' => $validated['currency'],
                    ]
                ];

                $sale = Sale::create([
                    'receipt_type' => 'FISCAL_INVOICE',
                    'receipt_currency' => $validated['currency'],
                    'receipt_counter' => $receiptCounter,
                    'receipt_global_no' => $receiptGlobalNo,
                    'invoice_no' => $invoiceNo,
                    'buyer_register_name' => 'CASH SALE',
                    'buyer_trade_name' => 'CASH SALE',
                    'vat_number' => null,
                    'buyer_tin' => null,
                    'buyer_contacts' => ['phone' => null, 'email' => null],
                    'buyer_address' => ['street' => null, 'city' => null, 'country' => 'ZW'],
                    'receipt_lines_tax_inclusive' => true,
                    'receipt_lines' => $receiptLines,
                    'receipt_taxes' => [],
                    'receipt_payments' => $receiptPayments,
                    'receipt_total' => $validated['total'],
                    'receipt_print_form' => 'POS',
                    'receipt_notes' => 'Point of Sale Transaction',
                    'receipt_date' => Carbon::now(),
                    'username' => auth()->user()->name ?? 'POS',
                    'username_surname' => auth()->user()->surname ?? '',
                ]);

                return response()->json([
                    'success' => true,
                    'sale_id' => $sale->id,
                    'invoice_no' => $sale->invoice_no,
                ], 201);
            });

        } catch (Exception $e) {
            Log::error('Sale creation failed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to create sale. Please try again.',
            ], 500);
        }
    }

    /* =======================
     * EDIT & UPDATE
     * ======================= */
    public function edit(Sale $sale)
    {
        return view('sales.edit', compact('sale'));
    }

    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'buyer_register_name' => 'required|string|max:255',
            'buyer_trade_name' => 'required|string|max:255',
            'buyer_tin' => 'nullable|string|max:50',
            'vat_number' => 'nullable|string|max:50',
            'buyer_contacts' => 'nullable|array',
            'buyer_contacts.phone' => 'nullable|string|max:50',
            'buyer_contacts.email' => 'nullable|email|max:100',
            'buyer_address' => 'nullable|array',
            'buyer_address.street' => 'nullable|string|max:255',
            'buyer_address.city' => 'nullable|string|max:100',
            'buyer_address.province' => 'nullable|string|max:100',
            'receipt_lines' => 'nullable|array',
            'receipt_lines.*.receiptLineName' => 'nullable|string|max:255',
            'receipt_lines.*.receiptLinePrice' => 'nullable|numeric|min:0',
            'receipt_lines.*.receiptLineQuantity' => 'nullable|integer|min:0',
            'receipt_lines.*.receiptLineTotal' => 'nullable|numeric|min:0',
            'receipt_lines.*.taxPercent' => 'nullable|numeric|min:0',
            'receipt_payments' => 'nullable|array',
            'receipt_payments.*.moneyTypeCode' => 'nullable|string|max:50',
            'receipt_payments.*.paymentAmount' => 'nullable|numeric|min:0',
            'receipt_total' => 'nullable|numeric|min:0',
            'receipt_notes' => 'nullable|string|max:1000',
        ]);

        try {
            $sale->update($validated);
            return redirect()->route('sales.show', $sale)->with('success', 'Invoice updated successfully.');
        } catch (Exception $e) {
            Log::error('Invoice update failed', ['sale_id' => $sale->id, 'error' => $e->getMessage()]);
            return back()->with('error', 'Failed to update invoice. Please try again.');
        }
    }

    /* =======================
     * DELETE
     * ======================= */
    public function destroy(Sale $sale)
    {
        try {
            $sale->delete();
            return redirect()->route('sales.index')->with('success', 'Invoice deleted successfully.');
        } catch (Exception $e) {
            Log::error('Invoice deletion failed', ['sale_id' => $sale->id, 'error' => $e->getMessage()]);
            return back()->with('error', 'Failed to delete invoice. Please try again.');
        }
    }

    /* =======================
     * CREDIT / DEBIT NOTES
     * ======================= */
    public function generateCreditNote(Sale $sale)
    {
        return $this->generateNote($sale, 'CreditNote', -1, 'Credit Note generated successfully.');
    }

    public function generateDebitNote(Sale $sale)
    {
        return $this->generateNote($sale, 'DebitNote', 1, 'Debit Note generated successfully.');
    }

    private function generateNote(Sale $sale, string $type, int $sign, string $successMessage)
    {
        try {
            if ($this->isNote($sale)) {
                return back()->with('error', 'You cannot generate a note from a note.');
            }

            if ($this->noteExists($sale->id, $type)) {
                return back()->with('info', "$type already exists for this invoice.");
            }

            $note = $this->createNote($sale, $type, $sign);

            return redirect()->route('sales.show', $note)->with('success', $successMessage);

        } catch (Exception $e) {
            Log::error("Failed to generate $type", ['sale_id' => $sale->id, 'error' => $e->getMessage()]);
            return back()->with('error', "Failed to generate $type. Please try again.");
        }
    }

    /* =======================
     * INTERNAL HELPERS
     * ======================= */
    private function isNote(Sale $sale): bool
    {
        return in_array($sale->receipt_type, ['CreditNote', 'DebitNote']);
    }

    private function noteExists(int $originalId, string $type): bool
    {
        return Sale::whereJsonContains('credit_debit_note->original_receipt_id', $originalId)
            ->whereJsonContains('credit_debit_note->type', $type)
            ->exists();
    }

    private function createNote(Sale $sale, string $type, int $sign): Sale
    {
        return DB::transaction(function () use ($sale, $type, $sign) {
            $exists = Sale::whereJsonContains('credit_debit_note->original_receipt_id', $sale->id)
                ->whereJsonContains('credit_debit_note->type', $type)
                ->lockForUpdate()
                ->exists();

            if ($exists) {
                throw new \RuntimeException("$type already exists for this invoice.");
            }

            $note = $sale->replicate();
            $note->receipt_type = $type;
            $note->invoice_no = strtoupper(substr($type, 0, 2)) . '-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
            $note->receipt_counter = (Sale::max('receipt_counter') ?? 0) + 1;
            $note->receipt_global_no = (Sale::max('receipt_global_no') ?? 0) + 1;
            $note->receipt_date = Carbon::now();

            $note->credit_debit_note = [
                'type' => $type,
                'original_invoice_no' => $sale->invoice_no,
                'original_receipt_id' => $sale->id,
                'reason' => "$type generated from invoice",
            ];

            $note->receipt_total = $sign * abs($sale->receipt_total);

            $note->receipt_lines = collect($sale->receipt_lines)->map(function ($line) use ($sign) {
                $line['receiptLineTotal'] = $sign * abs($line['receiptLineTotal'] ?? 0);
                return $line;
            })->values()->toArray();

            $note->receipt_taxes = collect($sale->receipt_taxes)->map(function ($tax) use ($sign) {
                $tax['taxAmount'] = $sign * abs($tax['taxAmount'] ?? 0);
                return $tax;
            })->values()->toArray();

            $note->receipt_payments = $sign < 0 ? [] : $sale->receipt_payments;
            $note->receipt_notes = "$type for Invoice {$sale->invoice_no}";

            $note->save();

            return $note;
        });
    }
}
