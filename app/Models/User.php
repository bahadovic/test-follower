<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['username', 'token', 'coins'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function coinTransactions()
    {
        return $this->hasMany(CoinTransaction::class);
    }

    public function interactedOrders()
    {
        return $this->belongsToMany(Order::class, 'order_user');
    }

}
