<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->char('key', 100)->unique();
            $table->text('value')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        $data = [
            [
                'key'=>'currency',
                'value'=>'12500',
                'description'=>'Currency of the system'
            ],
            [
                'key'=>'director',
                'value'=>'Mambetali Nokisbaev',
                'description'=>'Director of the company'
            ]
        ];

        DB::table('settings')->insert($data);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
