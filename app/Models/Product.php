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
        'installment_price',
        'installment_price_usd',
        'day_sale',
        'alert_quantity',
        'is_imei',
        'image',
    ];

    protected $appends = ['image_url', 'last_sale_day', 'last_purchase_day'];

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

    // sale_items
    public function sale_items()
    {
        return $this->hasMany(SaleItem::class);
    }

    // purchases
    public function purchase_items()
    {
        return $this->hasMany(PurchaseItem::class);
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
        else
        {
            $warehouse = new ProductWarehouse();
            $warehouse->product_id = $this->id;
            $warehouse->warehouse_id = $warehouse_id;
            $warehouse->quantity = 0;
            $warehouse->save();
        }
    }

    public function incrementQuantity($warehouse_id, $quantity)
    {
        $warehouse = $this->warehouses()->where('warehouse_id', $warehouse_id)->first();
        if ($warehouse) {
            $warehouse->pivot->increment('quantity', $quantity);
        }
        else
        {
            $warehouse = new ProductWarehouse();
            $warehouse->product_id = $this->id;
            $warehouse->warehouse_id = $warehouse_id;
            $warehouse->quantity = $quantity;
            $warehouse->save();
        }
    }

    public function last_sale_day($warehouse_id=null)
    {
        $sale_item = $this->sale_items()->latest()->first();
        $date = null;
        $day = 0;

        if ($sale_item) {
            $date = $sale_item->created_at;
            $day = now()->diffInDays($date);
            return $day . ' дней назад';
        }else{
            return 'Нет продаж';
        }
    }

    public function getLastSaleDayAttribute()
    {
        return $this->last_sale_day();
    }

    public function last_purchase_day($warehouse_id=null)
    {
        $purchase_item = $this->purchase_items()->latest()->first();
        $date = null;
        $day = 0;

        if ($purchase_item) {
            $date = $purchase_item->created_at;
            $day = now()->diffInDays($date);

            if ($day == 0) {
                return 'Сегодня';
            }

            return $day . ' дней назад';
        }else{
            return 'Нет покупок';
        }
    }

    public function getlastPurchaseDayAttribute()
    {
        return $this->last_purchase_day();
    }



}
