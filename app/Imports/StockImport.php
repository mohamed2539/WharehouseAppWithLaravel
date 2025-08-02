<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\StockItem;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class StockImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $rows->shift(); // حذف أول صف (Headers)

        foreach ($rows as $row) {
            $upc        = trim($row[0]);
            $location   = trim($row[1]);
            $styleName  = trim($row[2]);
            $color      = trim($row[3]);
            $size       = trim($row[4]);
            $quantity   = (int) $row[5];

            // البحث أو إنشاء المنتج
            $product = Product::firstOrCreate([
                'upc'        => $upc,
                'style_name' => $styleName,
                'color'      => $color,
                'size'       => $size,
            ]);

            // البحث عن stock في نفس الـ location
            $stock = StockItem::where('product_id', $product->id)
                              ->where('location', $location)
                              ->first();

            if ($stock) {
                $stock->quantity += $quantity;
                $stock->save();
            } else {
                StockItem::create([
                    'product_id' => $product->id,
                    'location'   => $location,
                    'quantity'   => $quantity,
                ]);
            }
        }
    }
}
