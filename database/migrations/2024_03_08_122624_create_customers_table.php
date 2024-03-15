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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('passport')->nullable();
            $table->date('passport_date')->nullable();
            $table->string('passport_by')->nullable();
            $table->string('address')->nullable();
            $table->integer('phone')->nullable();
            $table->foreignId('find_id')->nullable()->constrained('finds');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        $customers = [
            [
                'first_name' => 'По умолчанию',
                'description' => 'Клиент по умолчанию'
            ],
            [
                'first_name' => 'Shariyar',
                'last_name' => 'Jaksilikov',
                'address' => 'Nukus',
                'phone' => 901234567,
                'description' => 'Shariyar Jaksilikov'
            ],
        ];

        App\Models\Customer::create($customers[0]);
        App\Models\Customer::create($customers[1]);


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
