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
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->enum('action', ['increase', 'decrease']);
            $table->integer('qty');
            $table->date('stock_date');
            $table->string('purchase_rate');
            $table->string('purchase_no');
            $table->string('sales_invoice_no');
            $table->string('remarks')->nullable();
            $table->string('supplier_name');
            $table->string('chalan_no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_stocks');
    }
};
