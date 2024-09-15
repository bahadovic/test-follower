<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinTransaction extends Model
{

    protected $fillable = ['user_id', 'amount', 'transaction_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

