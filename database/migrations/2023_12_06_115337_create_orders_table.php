<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->string('customer_name')->nullable();
            $table->string('customer_mobile')->nullable();
            $table->string('customer_address')->nullable();
            $table->foreignId('product_id')->nullable()->constrained();
            $table->double('product_price', 10, 2)->nullable();
            $table->integer('quantity');
            $table->double('shipping_charge')->nullable();
            $table->double('total_price', 10, 2);
            $table->enum('payment_status', ['Paid', 'Unpaid'])->default('Unpaid');
            $table->enum('current_status', ['Pending', 'Packing', 'Delivery', 'Delivered', 'Canceled'])->default('Pending');
            $table->string('pay_now_qr')->nullable();
            $table->string('customer_sms')->nullable();
            $table->string('rider_sms')->nullable();
            $table->timestamps();
        });

        // Calculate total_price as the sum of product_price and shipping_charge
        DB::statement('UPDATE orders SET total_price = IFNULL(product_price, 0) + IFNULL(shipping_charge, 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
