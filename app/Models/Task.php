<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'installment_id',
        'customer_id',
        'user_id',
        'task',
        'date',
        'status',
        'task_result',
    ];

    public function installment()
    {
        return $this->belongsTo(Installment::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


}
