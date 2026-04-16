<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
    'user_id',
    'total_price',
    'paid',
    'change'
];

public function details()
{
    return $this->hasMany(\App\Models\TransactionDetail::class);
}

public function cashier()
{
    return $this->belongsTo(\App\Models\User::class, 'user_id');
}

}
