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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        $categories = [
            [
                'name' => 'Телефоны',
                'description' => 'Телефоны и смартфоны',
            ],
            [
                'name' => 'Ноутбуки',
                'description' => 'Ноутбуки и ультрабуки',
            ],
            [
                'name' => 'Планшеты',
                'description' => 'Планшеты и электронные книги',
            ],
            [
                'name' => 'Аксессуары',
                'description' => 'Аксессуары для телефонов и ноутбуков',
            ],
        ];

        App\Models\Category::insert($categories);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
