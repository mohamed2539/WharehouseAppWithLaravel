<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClearDatabaseSeeder extends Seeder
{
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
        \App\Models\StockItem::truncate();
        \App\Models\Product::truncate();
        \App\Models\Dispatch::truncate();
        // ضيف باقي الجداول هنا...
    
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
    
}
