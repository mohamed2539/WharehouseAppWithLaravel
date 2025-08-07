<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['upc', 'style_name', 'color', 'size'];

    public function stockItems()
    {
        return $this->hasMany(StockItem::class);
    }
}


