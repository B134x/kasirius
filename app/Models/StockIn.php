<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $fillable = ['product_id', 'qty', 'supplier'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
