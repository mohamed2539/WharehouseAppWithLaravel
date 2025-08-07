<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockItem extends Model
{
    protected $fillable = ['product_id', 'location', 'quantity'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    
}
