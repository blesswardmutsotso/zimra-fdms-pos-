<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();

            // Basic receipt info
            $table->string('receipt_type');
            $table->string('receipt_currency', 10);
            $table->unsignedBigInteger('receipt_counter');
            $table->unsignedBigInteger('receipt_global_no');
            $table->string('invoice_no')->unique();

            // Buyer
            $table->string('buyer_register_name');
            $table->string('buyer_trade_name')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('buyer_tin')->nullable();

            // JSON blocks (matches API exactly)
            $table->json('buyer_contacts');
            $table->json('buyer_address');
            $table->json('credit_debit_note')->nullable();

            // Receipt body
            $table->boolean('receipt_lines_tax_inclusive')->default(true);
            $table->json('receipt_lines');
            $table->json('receipt_taxes');
            $table->json('receipt_payments');

            // Totals & meta
            $table->decimal('receipt_total', 15, 2);
            $table->string('receipt_print_form')->default('Receipt48');
            $table->string('username');
            $table->string('username_surname');
            $table->text('receipt_notes')->nullable();
            $table->dateTime('receipt_date');

            // Fiscal signature
            $table->text('device_hash')->nullable();
            $table->text('device_signature')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
