<?php

use App\Models\InstallmentMonths;
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
        Schema::create('installment_months', function (Blueprint $table) {
            $table->id();
            $table->integer('month');
            $table->integer('percent');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        $months = [
            ['month' => 6, 'percent' => 20, 'description' => '6 months'],
            ['month' => 12, 'percent' => 50, 'description' => '12 months'],
            ['month' => 18, 'percent' => 80, 'description' => '18 months'],
            ['month' => 24, 'percent' => 100, 'description' => '24 months'],
        ];

        InstallmentMonths::insert($months);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installment_months');
    }
};
