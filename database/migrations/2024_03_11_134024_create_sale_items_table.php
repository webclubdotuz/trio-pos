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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            $table->integer('quantity');

            $table->decimal('price', 15, 0);
            $table->decimal('price_usd', 15, 0);

            $table->decimal('total', 15, 0);
            $table->decimal('total_usd', 15, 0);

            $table->decimal('currency_rate', 15, 0);

            $table->text('imei')->nullable();

            $table->decimal('in_price', 15, 0);
            $table->decimal('in_price_usd', 15, 0);
            $table->decimal('in_total', 15, 0);
            $table->decimal('in_total_usd', 15, 0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
