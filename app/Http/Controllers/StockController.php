<?php

namespace App\Http\Controllers;

use App\Models\StockItem;
use Illuminate\Http\Request;

class StockController extends Controller
{
    // عرض صفحة المخزون
    // public function manage()
    // {
    //     $stockItems = StockItem::with('product')->latest()->paginate(20);
    //     return view('stock.manage', compact('stockItems'));
    // }



    public function manage(Request $request)
    {
        $stockItems = StockItem::with('product')->latest()->paginate(20);
    
        if ($request->ajax()) {
            return view('stock._table', compact('stockItems'))->render(); // جزئية الجدول فقط
        }
    
        return view('stock.manage', compact('stockItems')); // الصفحة كلها
    }
    


    // حذف صنف واحد
    public function delete($id)
    {
        StockItem::findOrFail($id)->delete();
        return back()->with('success', 'تم حذف الصنف بنجاح.');
    }

    // حذف كل المخزون
    public function clearAll()
    {
        StockItem::truncate();
        return back()->with('success', 'تم حذف كل رصيد المخزون.');
    }
}

