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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string(column:'name');
            $table->string(column:'slug')->unique();
            $table->longText(column:'url')->nullable();
            $table->string(column:'primary_hex')->nullable();
            $table->boolean(column:'is_available')->default(value:false);
            $table->longText(column:'description')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
