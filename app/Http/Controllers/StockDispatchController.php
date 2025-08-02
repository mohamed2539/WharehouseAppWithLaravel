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

        public function storeManual(Request $request)
        {
            $validated = $request->validate([
                'upc' => 'required|string',
                'style_name' => 'required|string',
                'color' => 'required|string',
                'size' => 'required|string',
                'location' => 'required|string',
                'quantity' => 'required|integer|min:1',
                'store_name' => 'nullable|string',
            ]);

            $product = Product::where('upc', $validated['upc'])
                ->where('style_name', $validated['style_name'])
                ->where('color', $validated['color'])
                ->where('size', $validated['size'])
                ->first();

            if (!$product) {
                return back()->withErrors(['msg' => 'الصنف غير موجود'])->withInput();
            }

            $stock = StockItem::where('product_id', $product->id)
                ->where('location', $validated['location'])
                ->first();

            if (!$stock || $stock->quantity < $validated['quantity']) {
                return back()->withErrors(['msg' => 'الرصيد غير كافٍ في هذا الـ Location'])->withInput();
            }

            // خصم الكمية
            $stock->quantity -= $validated['quantity'];
            $stock->save();

            // حفظ سجل العملية
            DispatchTransaction::create([
                'product_id' => $product->id,
                'location' => $stock->location,
                'dispatched_quantity' => $validated['quantity'],
                'store_name' => $validated['store_name'] ?? 'غير محدد',
            ]);

            return redirect()->back()->with('success', 'تم صرف الكمية بنجاح ✅');
        }

}

