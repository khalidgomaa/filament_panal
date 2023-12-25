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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column:'order_id')
            ->constrained(table:'orders')->cascadeOnDelete();

            $table->foreignId(column:'product_id')
            ->constrained(table:'products')->cascadeOnDelete();
            $table->unsignedBigInteger(column:'quantity');
            $table->decimal(column:'unit_price',total:10,places:2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
