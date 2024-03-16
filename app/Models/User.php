<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

//
class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    protected $fillable = [
        'fullname',
        'username',
        'phone',
        'is_all_warehouses',
        'password',
    ];

    protected $hidden = [
        'password'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class);
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class, 'user_id');
    }



    public function getBalanceAttribute()
    {
        // return $this->papers->sum('user_amount') - getSalaryModelSumma($this->id);
    }


    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function HasRole($role)
    {
        return $this->roles()->where('slug', $role)->exists();
    }


}
