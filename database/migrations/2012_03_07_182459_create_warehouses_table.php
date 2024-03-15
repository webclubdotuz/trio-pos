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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        $warehouses = [
            [
                'name' => 'Склад 1',
                'phone' => '934879598',
                'address' => 'г. Тахиаташ, ул. Шахрисабзи 1',
            ],
        ];

        App\Models\Warehouse::insert($warehouses);
    }

    /**
     * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
