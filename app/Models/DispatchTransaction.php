<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DispatchTransaction extends Model
{
    protected $fillable = [
        'product_id', 'location', 'dispatched_quantity', 'store_name'
    ];
}
