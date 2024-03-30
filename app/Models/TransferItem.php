<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransferItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transfer_id',
        'from_warehouse_id',
        'to_warehouse_id',
        'product_id',
        'quantity',
        'date',
        'description',
    ];

    public function transfer()
    {
        return $this->belongsTo(Transfer::class);
    }
}
