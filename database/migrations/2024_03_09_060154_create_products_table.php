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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('code')->unique();
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
            $table->char('unit', 10);
            $table->decimal('in_price', 14, 0);
            $table->decimal('in_price_usd', 14, 0);
            $table->decimal('price', 14, 0);
            $table->decimal('price_usd', 14, 0);
            $table->integer('day_sale')->nullable();
            $table->integer('alert_quantity')->default(0);
            $table->boolean('is_imei')->default(false);
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Product Warehouse Table
        Schema::create('product_warehouse', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
            $table->integer('quantity')->default(0);
            $table->unique(['product_id', 'warehouse_id']);
            $table->timestamps();
            $table->softDeletes();
        });

        $products = [
            [
                'name' => 'Samsung Galaxy S21',
                'code' => 1001,
                'description' => 'Samsung Galaxy S21 5G 128GB Phantom Gray',
                'category_id' => 1,
                'brand_id' => 2,
                'unit' => 'шт',
                'in_price' => 100000,
                'in_price_usd' => 1200,
                'price' => 110000,
                'price_usd' => 1300,
                'day_sale' => 0,
                'alert_quantity' => 10,
                'is_imei' => true,
            ],
        ];

        App\Models\Product::create($products[0]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_warehouse');
        Schema::dropIfExists('products');
    }
};
