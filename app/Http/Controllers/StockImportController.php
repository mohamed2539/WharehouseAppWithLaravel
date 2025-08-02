<?php

namespace App\Http\Controllers;


use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Imports\StockImport;
use App\Exports\StockExport;
use App\Models\StockItem;
use Illuminate\Support\Facades\DB;


class StockImportController extends Controller
{
    public function importForm()
    {
        return view('stock.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
    
        Excel::import(new StockImport, $request->file('file'));
    
        return redirect()->route('stock.latest')->with('success', '✅ تم استيراد البيانات بنجاح.');
    }



    public function latest()
{
    // نعرض أحدث 100 صنف بالترتيب من الأجدد للأقدم مع بيانات المنتج
    $stockItems = StockItem::with('product')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10); // Laravel pagination

    return view('stock.latest', compact('stockItems'));
}



public function export()
{
    return Excel::download(new StockExport, 'latest_stock.xlsx');
}




public function searchPage()
{
    return view('stock.search');
}

public function liveSearch(Request $request)
{
    $query = $request->input('query');

    $results = StockItem::with('product')
        ->whereHas('product', function ($q) use ($query) {
            $q->where('upc', 'like', "%$query%")
              ->orWhere('style_name', 'like', "%$query%")
              ->orWhere('color', 'like', "%$query%")
              ->orWhere('size', 'like', "%$query%");
        })
        ->orWhere('location', 'like', "%$query%")
        ->limit(20)
        ->get();

    return response()->json($results);
}


//Live add Quantity

public function liveAddPage()
{
    $stockItems = StockItem::with('product')->latest()->paginate(10);
    return view('stock.live_add_quantity', compact('stockItems'));
}


public function getStockItem($id)
{
    $item = StockItem::with('product')->findOrFail($id);
    return response()->json($item);
}



public function updateStockQuantity(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    $item = StockItem::findOrFail($id);
    $item->quantity += $request->input('quantity');
    $item->save();

    return response()->json([
        'success' => true,
        'message' => '✅ تم إضافة الكمية بنجاح.',
        'new_quantity' => $item->quantity
    ]);
}



}
