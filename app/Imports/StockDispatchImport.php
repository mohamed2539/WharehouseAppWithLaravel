<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\StockItem;
use App\Models\DispatchTransaction;
use Illuminate\Support\Collection;
use App\Exports\DispatchExport;
use Maatwebsite\Excel\Concerns\ToCollection;

class StockDispatchImport implements ToCollection
{
    public $dispatched = [];
    public $notFound = [];

    public function collection(Collection $rows)
    {
        // إزالة أول صف لو فيه headers
        $rows->shift();

        foreach ($rows as $row) {
            $upc   = trim($row[0]);
            $style = trim($row[1]);
            $color = trim($row[2]);
            $size  = trim($row[3]);
            $qty   = (int) $row[4];

            $product = Product::where('upc', $upc)
                ->where('style_name', $style)
                ->where('color', $color)
                ->where('size', $size)
                ->first();

            if (!$product) {
                $this->notFound[] = [
                    'upc' => $upc,
                    'style' => $style,
                    'color' => $color,
                    'size' => $size,
                    'qty' => $qty
                ];
                continue;
            }

            $remaining = $qty;

            // نحاول نصرف من أماكن التخزين حسب الترتيب
            $stockItems = StockItem::where('product_id', $product->id)
                ->where('quantity', '>', 0)
                ->orderBy('created_at') // أو orderBy('id') للبساطة
                ->get();

                foreach ($stockItems as $stock) {
                    if ($remaining <= 0) break;
                
                    $deduct = min($remaining, $stock->quantity);
                    $stock->quantity -= $deduct;
                    $stock->save();
                
                    // 🟢 تسجيل العملية في جدول المعاملات (dispatch_transactions)
                    DispatchTransaction::create([
                        'product_id' => $product->id,
                        'location' => $stock->location,
                        'dispatched_quantity' => $deduct,
                        'store_name' => $row[4] ?? 'Unknown', // ✅ العمود رقم 5 هو اسم المحل (ONL)
                    ]);
                
                    $remaining -= $deduct;
                
                    $this->dispatched[] = [
                        'upc' => $product->upc,
                        'style' => $product->style_name,
                        'color' => $product->color,
                        'size' => $product->size,
                        'location' => $stock->location,
                        'dispatched' => $deduct,
                    ];
                }

            // لو باقي كمية بعد المرور → نعتبر إن الكمية غير متوفرة بالكامل
            if ($remaining > 0) {
                $this->notFound[] = [
                    'upc' => $upc,
                    'style' => $style,
                    'color' => $color,
                    'size' => $size,
                    'qty' => $remaining
                ];
            }
        }
    }


    public function export(Request $request)
    {
        $data = json_decode($request->input('data'), true);
        return Excel::download(new DispatchExport($data), 'dispatch_result.xlsx');
    }





}

