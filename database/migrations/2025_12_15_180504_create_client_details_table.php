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
        Schema::create('client_details', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('taxpayer_name');
            $table->string('tin_number');
            $table->string('vat_number')->nullable();
            $table->string('address');
            $table->string('house_address')->nullable();
            $table->string('street_name')->nullable();
            $table->string('town')->nullable();
            $table->string('province')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_details');
    }
};
