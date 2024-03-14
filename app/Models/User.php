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
        'password',
    ];

    protected $hidden = [
        'password'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function balanses()
    {
        return $this->hasMany(Balans::class, 'user_id');
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class, 'user_id');
    }

    public function papers()
    {
        return $this->hasMany(Paper::class, 'user_id', 'id');
    }

    public function getBalanceAttribute()
    {
        // return $this->papers->sum('user_amount') - getSalaryModelSumma($this->id);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function balans()
    {
        return $this->hasMany(Balans::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function HasRole($role)
    {
        return $this->roles()->where('slug', $role)->exists();
    }


}
