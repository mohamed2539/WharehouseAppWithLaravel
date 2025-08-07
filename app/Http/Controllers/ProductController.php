<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockItem;

class ProductController extends Controller
{
    // Autocomplete
    public function autocomplete(Request $request)
    {
        $search = $request->get('term');

        $results = Product::where('upc', 'LIKE', "%{$search}%")
            ->limit(10)
            ->get(['id', 'upc']);

        return $results->map(function ($product) {
            return [
                'id' => $product->id,
                'value' => $product->upc, // يعرض اللى هيظهر فى الاقتراح
            ];
        });
    }

    // Get full product details
    public function getDetails(Request $request)
    {
        $id = $request->get('id');

        $product = Product::findOrFail($id);

        // نجيب الكمية الإجمالية من جدول stock_items
        $quantity = StockItem::where('product_id', $id)->sum('quantity');

        return response()->json([
            'style' => $product->style_name,
            'color' => $product->color,
            'size' => $product->size,
            'quantity' => $quantity,
        ]);
    }
}
