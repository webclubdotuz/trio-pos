<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('username')->unique();
            $table->integer('phone')->unique();
            $table->string('password');
            $table->boolean('is_all_warehouses')->default(false);
            $table->decimal('plan', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('user_warehouse', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
        });

        DB::table('users')->insert([
            'fullname' => 'Admin',
            'username' => 'admin',
            'phone' => '934879598',
            'password' => bcrypt('admin'),
            'is_all_warehouses' => true
        ]);

        DB::table('users')->insert([
            'fullname' => 'Salesman 1',
            'username' => 'salesman1',
            'phone' => '934879591',
            'password' => bcrypt('123456')
        ]);

        DB::table('users')->insert([
            'fullname' => 'Manager 1',
            'username' => 'manager1',
            'phone' => '934879590',
            'password' => bcrypt('123456')
        ]);




    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
