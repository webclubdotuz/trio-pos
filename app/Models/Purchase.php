<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'supplier_id',
        'warehouse_id',
        'user_id',
        'invoice_number',
        'total',
        'total_usd',
        'currency_rate',
        'payment_status',
        'description',
        'date',
    ];

    public function scopeFilter($builder, $filters)
    {
        return $filters->apply($builder);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchase_items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function purchase_payments()
    {
        return $this->hasMany(PurchasePayment::class);
    }

    public function getDebtAttribute()
    {
        return $this->total - $this->purchase_payments->sum('amount');
    }

    public function getDebtUsdAttribute()
    {
        return $this->total_usd - $this->purchase_payments->sum('amount_usd');
    }

    public function getStatusHtmlAttribute()
    {
        if ($this->payment_status == 'paid') {
            return '<span class="badge bg-success">Оплачено</span>';
        } else {
            return '<span class="badge bg-danger">Долг $'.$this->debt_usd.'</span>';
        }
    }
}
