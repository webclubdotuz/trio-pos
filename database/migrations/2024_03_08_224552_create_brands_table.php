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
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        $brands = [
            [
                'name' => 'Artel',
                'description' => 'Артель - узбекский производитель бытовой техники',
            ],
            [
                'name' => 'Samsung',
                'description' => 'Samsung - южнокорейский производитель электроники',
            ],
            [
                'name' => 'Apple',
                'description' => 'Apple - американский производитель электроники',
            ],
            [
                'name' => 'Xiaomi',
                'description' => 'Xiaomi - китайский производитель электроники',
            ],
        ];

        App\Models\Brand::insert($brands);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
