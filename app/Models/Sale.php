<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'warehouse_id', // 'warehouse_id' added
        'user_id',
        'total',
        'total_usd',
        'currency_rate',
        'payment_status',

        'installment_status',
        'installment_first_payment',
        'installment_percent',
        'installment_month',

        'date'
    ];


    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(SalePayment::class);
    }

    public function sale_payments()
    {
        return $this->hasMany(SalePayment::class);
    }

    public function sale_items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function getDebtAttribute()
    {
        return $this->total - $this->payments->sum('amount');
    }

    public function getPaidAttribute()
    {
        return $this->payments->sum('amount');
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }



    public function getStatusHtmlAttribute()
    {
        // debt, installment, paid
        if ($this->payment_status == 'debt') {
            return '<span class="badge bg-danger">Долг ' . nf($this->debt) . '</span>';
        } elseif ($this->payment_status == 'installment') {
            return '<span class="badge bg-warning">Рассрочка</span>';
        } elseif ($this->payment_status == 'paid') {
            return '<span class="badge bg-success">Оплачено</span>';
        }
    }

    // fact_debt
    public function getFactDebtAttribute()
    {
        $debt = 0;
        foreach ($this->installments as $installment) {
            if (date('Y-m-d') >= $installment->date && $installment->debt > 0)
            {
                $debt += $installment->debt;
            }
        }

        return $debt;
    }

    public function getFactDebtMonthCountAttribute()
    {
        $count = 0;

        foreach ($this->installments as $installment) {
            if (date('Y-m-d') >= $installment->date && $installment->debt > 0)
            {
                $count++;
            }
        }

        return $count;
    }

}
