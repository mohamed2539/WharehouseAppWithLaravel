<?php

namespace App\Exports;

use App\Models\StockItem;
use Maatwebsite\Excel\Concerns\FromCollection;

class StockExport implements FromCollection
{
    public function collection()
    {
        return StockItem::with('product')->get()->map(function ($item) {
            return [
                'UPC'       => $item->product->upc,
                'Style'     => $item->product->style_name,
                'Color'     => $item->product->color,
                'Size'      => $item->product->size,
                'Location'  => $item->location,
                'Quantity'  => $item->quantity,
                'Created'   => $item->created_at->format('Y-m-d H:i'),
            ];
        });
    }
}
