<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description'
    ];

    function sale_payments()
    {
        return $this->hasMany(SalePayment::class);
    }

    function purchase_payments()
    {
        return $this->hasMany(PurchasePayment::class);
    }

    function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
