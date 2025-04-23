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
        Schema::create('sales', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('receipt_id');
            $table->unsignedBigInteger('drug_id');
            $table->integer('quantity');
            $table->decimal('selling_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->string('customer_name');
            $table->timestamps();

            $table->foreign('drug_id')->references('id')->on('drugs')->onDelete('cascade');
            $table->foreign('receipt_id')->references('id')->on('receipts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
