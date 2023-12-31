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
            $table->string('title');
            $table->string('barcode');
            $table->integer('qty')->nullable();
            $table->string('size')->nullable();
            $table->string('type')->nullable();
            $table->double('price', 10, 2);
            $table->foreignId('unit_id')->nullable()->constrained('units');
            $table->foreignId('color_id')->nullable()->constrained('colors');
            $table->string('image')->nullable();
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
