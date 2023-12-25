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
            $table->foreignId(column:"customer_id")
                ->constrained(table:'customers')
                ->cascadOnDelete();
            $table->string(column:'number')->unique();
            $table->decimal(column:'price',total:10,places:2);
            $table->enum('status', ['pending', 'processing','completed','declined'])
            ->default(value:'pending');
            $table->decimal(column:'shipping_price')->nullable();
            $table->longText(column:'notes');
            $table->softDeletes();

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
