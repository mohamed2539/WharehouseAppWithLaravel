<?php

namespace App\Http\Controllers;

use App\Exports\DispatchExport;
use Illuminate\Http\Request;
use App\Imports\StockDispatchImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Product;
use App\Models\StockItem;
use App\Models\DispatchTransaction;

class StockDispatchController extends Controller
{
    public function form()
    {
        return view('stock.dispatch_form');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $importer = new StockDispatchImport();
        Excel::import($importer, $request->file('file'));

        return view('stock.dispatch_result', [
            'dispatchedItems' => $importer->dispatched,
            'notFoundItems' => $importer->notFound,
        ]);
    }



    public function export(Request $request)
    {
        $data = json_decode($request->input('data'), true);
        return Excel::download(new DispatchExport($data), 'dispatch_result.xlsx');
    }






        public function manualForm()
        {
            return view('dispatch.manual');
        }

        // public function storeManual(Request $request)
        // {
        //     $validated = $request->validate([
        //         'upc' => 'required|string',
        //         'style_name' => 'required|string',
        //         'color' => 'required|string',
        //         'size' => 'required|string',
        //         'location' => 'required|string',
        //         'quantity' => 'required|integer|min:1',
        //         'store_name' => 'nullable|string',
        //     ]);

        //     $product = Product::where('upc', $validated['upc'])
        //         ->where('style_name', $validated['style_name'])
        //         ->where('color', $validated['color'])
        //         ->where('size', $validated['size'])
        //         ->first();

        //     if (!$product) {
        //         return back()->withErrors(['msg' => 'الصنف غير موجود'])->withInput();
        //     }

        //     $stock = StockItem::where('product_id', $product->id)
        //         ->where('location', $validated['location'])
        //         ->first();

        //     if (!$stock || $stock->quantity < $validated['quantity']) {
        //         return back()->withErrors(['msg' => 'الرصيد غير كافٍ في هذا الـ Location'])->withInput();
        //     }

        //     // خصم الكمية
        //     $stock->quantity -= $validated['quantity'];
        //     $stock->save();

        //     // حفظ سجل العملية
        //     DispatchTransaction::create([
        //         'product_id' => $product->id,
        //         'location' => $stock->location,
        //         'dispatched_quantity' => $validated['quantity'],
        //         'store_name' => $validated['store_name'] ?? 'غير محدد',
        //     ]);

        //     return redirect()->back()->with('success', 'تم صرف الكمية بنجاح ✅');
        // }



        public function storeManual(Request $request)
        {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
            ]);

            
            $product = Product::find($request->product_id);
            $remaining = $request->quantity;
        
            $stockItems = StockItem::where('product_id', $product->id)
                ->where('quantity', '>', 0)
                ->orderBy('created_at')
                ->get();
        
            if ($stockItems->sum('quantity') < $remaining) {
                return back()->withErrors("🔴 الكمية المطلوبة غير متوفرة حاليًا.")->withInput();
            }
        
            foreach ($stockItems as $stock) {
                if ($remaining <= 0) break;
        
                $deduct = min($remaining, $stock->quantity);
                $stock->quantity -= $deduct;
                $stock->save();
        
                // سجل عملية الصرف
                DispatchTransaction::create([
                    'product_id' => $product->id,
                    'location' => $stock->location,
                    'dispatched_quantity' => $deduct,
                    'store_name' => $request->store_name ?? 'غير محدد',
                    'dispatched_at' => now(),
                ]);
        
                $remaining -= $deduct;
            }
        
            return redirect()->back()->with('success', '✅ تم صرف الكمية بنجاح.');
        }
        




        //autocomplete function
        public function autocomplete(Request $request)
        {
            $term = $request->get('term');
        
            $results = Product::where('upc', 'LIKE', "%$term%")
                ->limit(10)
                ->get(['id', 'upc', 'style_name', 'color', 'size']);
        
            $formatted = $results->map(function ($item) {
                return [
                    'label' => "{$item->upc} - {$item->style_name} - {$item->color} - {$item->size}",
                    'value' => $item->upc,
                    'id'    => $item->id,
                ];
            });
        
            return response()->json($formatted);
        }
        
        public function productDetails(Request $request)
        {
            $product = Product::with(['stockItems'])->find($request->get('id'));
        
            if (!$product) {
                return response()->json(['error' => 'Not found'], 404);
            }
        
            $totalQty = $product->stockItems->sum('quantity');
        
            return response()->json([
                'style' => $product->style_name,
                'color' => $product->color,
                'size'  => $product->size,
                'quantity' => $totalQty
            ]);
        }


}

