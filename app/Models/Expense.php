<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'expense_category_id',
        'warehouse_id', // 'nullable|exists:warehouses,id',
        'user_id',
        'to_user_id',
        'amount',
        'payment_method_id',
        'method',
        'description',
    ];

    public function scopeFilter($builder, $filters)
    {
        return $filters->apply($builder);
    }

    public function expense_category()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function to_user()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
