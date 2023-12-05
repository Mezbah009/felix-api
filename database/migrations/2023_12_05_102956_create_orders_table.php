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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained();
            $table->foreignId('product_id')->nullable()->constrained();
            $table->integer('quantity');
            $table->double('shipping_charge')->nullable();
            $table->double('total_price', 10, 2);
            $table->string('status')->default('Pending');
            $table->string('payment_status')->default('Unpaid'); // Add this line for payment status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
