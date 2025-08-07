<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\DispatchTransaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // إجمالي عدد المنتجات
        $totalProducts = Product::count();

        // حساب عدد العمليات في آخر 7 أيام
        $last7Days = Carbon::now()->subDays(6)->startOfDay();

        $weeklyDispatches = DispatchTransaction::where('created_at', '>=', $last7Days)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date');

        // المنتجات اللي رصيدها صفر أو أقل
        $outOfStockProducts = Product::whereHas('stockItems', function ($query) {
            $query->havingRaw('SUM(quantity) <= 0');
        })->with('stockItems')->paginate(10);

        // ملخص الرصيد لكل منتج باستخدام withSum
        $stockSummary = \DB::table('products')
        ->leftJoin('stock_items', 'products.id', '=', 'stock_items.product_id')
        ->select(
            'products.id',
            'products.upc',
            'products.style_name',
            'products.color',
            'products.size',
            \DB::raw('COALESCE(SUM(stock_items.quantity), 0) as total_quantity')
        )
        ->groupBy(
            'products.id',
            'products.upc',
            'products.style_name',
            'products.color',
            'products.size'
        )
        ->paginate(10);
    

        return view('dashboard.index', compact(
            'totalProducts',
            'weeklyDispatches',
            'outOfStockProducts',
            'stockSummary'));
        }


    



    public function exportMissing()
    {
        $missing = Product::whereHas('stockItems', function ($q) {
            $q->havingRaw('SUM(quantity) <= 0');
        })->with('stockItems')->get();
        
    
        $exportData = $missing->map(function ($p) {
            return [
                'UPC' => $p->upc,
                'Style' => $p->style_name,
                'Color' => $p->color,
                'Size' => $p->size,
            ];
        });
    
        return Excel::download(new \App\Exports\ArrayExport($exportData), 'missing_stock.xlsx');
    }





}



?>