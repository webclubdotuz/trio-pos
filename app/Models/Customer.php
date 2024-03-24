<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'passport',
        'passport_date',
        'passport_by',
        'address',
        'phone',
        'find_id',
        'description',
    ];

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name . ' ' . $this->middle_name;
    }

    public function find()
    {
        return $this->belongsTo(Find::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function sale_payments()
    {
        return $this->hasMany(SalePayment::class);
    }

    // debt
    public function getDebtAttribute(): float
    {
        return $this->sales->sum('amount') - $this->sales->sale_payments->sum('amount');
    }


    public function getBalanceAttribute(): float
    {
        return $this->sales?->sum('paid')-$this->sales->sum('total');
    }
}
