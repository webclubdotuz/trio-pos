<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Installment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sale_id',
        'customer_id',
        'date',
        'amount',
        'status',
        'amount_usd',
        'currency_rate',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sale_payments()
    {
        return $this->hasMany(SalePayment::class, 'installment_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function getPaidAttribute()
    {
        return $this->sale_payments->sum('amount');
    }

    public function getDebtAttribute()
    {
        return $this->amount - $this->paid;
    }

    // status_html
    public function getStatusHtmlAttribute()
    {
        if ($this->status == 'paid') {
            return '<span class="badge bg-success">Оплачено</span>';
        } if ($this->status == 'debt') {
            return '<span class="badge bg-danger">Долг</span>';
        }
        else {
            return '<span class="badge bg-danger">Не оплачено</span>';
        }
    }

}
