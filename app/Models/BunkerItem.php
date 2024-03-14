<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BunkerItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'bunker_id', // <-- Add this line
        'product_id',
        'quantity',
    ];

    public function bunker()
    {
        return $this->belongsTo(Bunker::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
