<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'category_id',
        'brand_id',
        'unit',
        'in_price',
        'in_price_usd',
        'price',
        'price_usd',
        'day_sale',
        'alert_quantity',
        'is_imei',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class)->withPivot('quantity')->withTimestamps();
    }

    public function product_warehouse()
    {
        return $this->hasMany(ProductWarehouse::class, 'product_id', 'id');
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/no-image.png');
    }

    public function quantity($warehouse_id=null)
    {
        if ($warehouse_id) {
            $warehouse = $this->warehouses()->where('warehouse_id', $warehouse_id)->first();
            return $warehouse ? $warehouse->pivot->quantity : 0;
        }

        return $this->warehouses->sum('pivot.quantity');
    }

    public function decrementQuantity($warehouse_id, $quantity)
    {
        $warehouse = $this->warehouses()->where('warehouse_id', $warehouse_id)->first();
        if ($warehouse) {
            $warehouse->pivot->decrement('quantity', $quantity);
        }
    }

    public function incrementQuantity($warehouse_id, $quantity)
    {
        $warehouse = $this->warehouses()->where('warehouse_id', $warehouse_id)->first();
        if ($warehouse) {
            $warehouse->pivot->increment('quantity', $quantity);
        }
    }

}
