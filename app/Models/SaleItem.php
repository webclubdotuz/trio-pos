<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'warehouse_id', // 'warehouse_id' added
        'product_id',
        'quantity',
        'price',
        'price_usd',
        'total',
        'total_usd',
        'currency_rate',
        'imei',
        'in_price',
        'in_price_usd',
        'in_total',
        'in_total_usd'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }
}
