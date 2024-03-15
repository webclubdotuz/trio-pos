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
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->decimal('total', 15, 0);
            $table->decimal('total_usd', 15, 0);
            $table->decimal('currency_rate', 15, 0);

            $table->enum('payment_status', ['debt', 'installment', 'paid'])->default('debt');

            $table->boolean('installment_status')->default(false);
            $table->integer('installment_first_payment')->nullable();
            $table->integer('installment_percent')->nullable();
            $table->integer('installment_month')->nullable();

            $table->timestamp('date');
            $table->timestamps();
            $table->softDeletes();
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
