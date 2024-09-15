<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'number_of_followers','followers_left', 'completed'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function interactedUsers()
    {
        return $this->belongsToMany(User::class, 'order_user');
    }
}

