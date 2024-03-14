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
            $table->timestamps();
        });

        DB::table('users')->insert([
            'fullname' => 'Admin',
            'username' => 'admin',
            'phone' => '934879598',
            'password' => bcrypt('admin')
        ]);

        DB::table('users')->insert([
            'fullname' => 'Manager 1',
            'username' => 'manager1',
            'phone' => '934879590',
            'password' => bcrypt('123456')
        ]);

        DB::table('users')->insert([
            'fullname' => 'Manager 2',
            'username' => 'manager2',
            'phone' => '934879591',
            'password' => bcrypt('123456')
        ]);

        DB::table('users')->insert([
            'fullname' => 'Presser 1',
            'username' => 'presser1',
            'phone' => '934879592',
            'password' => bcrypt('123456')
        ]);

        DB::table('users')->insert([
            'fullname' => 'Presser 2',
            'username' => 'presser2',
            'phone' => '934879593',
            'password' => bcrypt('123456')
        ]);

        DB::table('users')->insert([
            'fullname' => 'Presser 3',
            'username' => 'presser3',
            'phone' => '934879594',
            'password' => bcrypt('123456')
        ]);

        DB::table('users')->insert([
            'fullname' => 'Presser 4',
            'username' => 'presser4',
            'phone' => '934879595',
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
