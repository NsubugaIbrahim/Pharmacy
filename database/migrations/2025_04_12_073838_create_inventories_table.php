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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restock_id');
            $table->unsignedBigInteger('drug_id');
            $table->integer('quantity');
            $table->integer('selling_price')->nullable();
            $table->date('expiry_date');
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('restock_id')->references('id')->on('stock_orders')->onDelete('cascade');
            $table->foreign('drug_id')->references('id')->on('drugs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
