<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'paket_id',
        'user_id',
        'quantity',
        'description',
        'user_amount'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function paket()
    {
        return $this->belongsTo(Product::class, 'paket_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
