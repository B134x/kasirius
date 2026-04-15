<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
    'total_price',
    'paid',
    'change'
];

public function details()
{
    return $this->hasMany(\App\Models\TransactionDetail::class);
}

}
