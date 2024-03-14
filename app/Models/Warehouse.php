<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'address',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity')->withTimestamps();
    }

    public function purchase_items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function getProductsQuantity($product_id)
    {
        return $this->products()->wherePivot('product_id', $product_id)->first()->pivot->quantity;
    }
}
