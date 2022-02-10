<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function is_admin()
    {
        return $this->admin;
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function cart_items()
    {
        return $this->hasMany(Cart::class);
    }

    public function order_items()
    {
        return $this->hasMany(Order_item::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class)->where("step", "=", 5);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    public function current_order()
    {
        return $this->hasOne(Order::class)->where("step", "<", 5);
    }
}
