<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // Product category
            $table->string('name');     // Product name
            $table->enum('unit', ['single', 'bulk']); // Unit type
            $table->text('description')->nullable();  // Description
            $table->decimal('selling_price', 12, 2); // Selling price
            $table->decimal('buying_price', 12, 2);  // Buying price
            $table->enum('tax', ['0%', '15%', 'ext'])->default('0%')->comment('Tax options: 0%, 15%, exempt');
            $table->string('hscode')->nullable();     // HS Code
            $table->date('expiry_date')->nullable();  // Expiry date
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
