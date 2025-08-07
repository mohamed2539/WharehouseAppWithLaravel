<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\DispatchTransaction;
use App\Models\StockItem;
use App\Models\Product;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArrayExport;

class ReportController extends Controller
{




    // public function importReport(Request $request)
    // {
    //     $from = $request->input('from');
    //     $to = $request->input('to');

    //     $imports = collect();

    //     if ($from && $to) {
    //         $fromDate = Carbon::parse($from)->startOfDay();
    //         $toDate = Carbon::parse($to)->endOfDay();

    //         $imports = StockItem::with('product')
    //             ->whereBetween('created_at', [$fromDate, $toDate])
    //             ->latest()
    //             ->paginate(20);
    //     }

    //     return view('report.import', compact('imports', 'from', 'to'));
    // }


    public function dispatchReport(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
    
        $dispatches = collect();
    
        if ($from && $to) {
            $fromDate = Carbon::parse($from)->startOfDay();
            $toDate = Carbon::parse($to)->endOfDay();
    
            $dispatches = DispatchTransaction::select('id', 'product_id', 'location', 'dispatched_quantity', 'store_name','created_at')
                ->with('product')
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->latest()
                ->paginate(20);
        }
    
        return view('report.dispatch', compact('dispatches', 'from', 'to'));
    }
    

    public function importReport(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $imports = collect();

        if ($from && $to) {
            $fromDate = Carbon::parse($from)->startOfDay();
            $toDate = Carbon::parse($to)->endOfDay();

            $imports = StockItem::with('product')
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->latest()
                ->paginate(20);
        }

        return view('report.import', compact('imports', 'from', 'to'));
    }

    
    public function exportDispatch(Request $request)
    {
        $fromDate = Carbon::parse($request->input('from'))->startOfDay();
        $toDate = Carbon::parse($request->input('to'))->endOfDay();

        $dispatches = DispatchTransaction::with('product')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->get();

        $exportData = $dispatches->map(function ($item) {
            return [
                'UPC' => $item->product->upc ?? '-',
                'Style' => $item->product->style_name ?? '-',
                'Color' => $item->product->color ?? '-',
                'Size' => $item->product->size ?? '-',
                'Quantity' => $item->dispatched_quantity,
                'Location' => $item->location,
                'Date' => $item->created_at,
            ];
        });

        return Excel::download(new ArrayExport($exportData), 'dispatches_report.xlsx');
    }

    public function exportImport(Request $request)
    {
        $fromDate = Carbon::parse($request->input('from'))->startOfDay();
        $toDate = Carbon::parse($request->input('to'))->endOfDay();

        $imports = StockItem::with('product')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->get();

        $exportData = $imports->map(function ($item) {
            return [
                'UPC' => $item->product->upc ?? '-',
                'Style' => $item->product->style_name ?? '-',
                'Color' => $item->product->color ?? '-',
                'Size' => $item->product->size ?? '-',
                'Quantity' => $item->dispatched_quantity,
                'Location' => $item->location,
                'Date' => $item->created_at,
            ];
        });

        return Excel::download(new ArrayExport($exportData), 'imports_report.xlsx');
    }






















    // public function index(Request $request)
    // {
    //     $from = $request->input('from');
    //     $to = $request->input('to');
    
    //     $dispatches = collect();
    //     $imports = collect();
    
    //     if ($from && $to) {
    //         // نحولهم إلى بداية ونهاية اليوم
    //         $fromDate = Carbon::parse($from)->startOfDay();
    //         $toDate = Carbon::parse($to)->endOfDay();
    
    //         $dispatches = DispatchTransaction::with('product')
    //             ->whereBetween('created_at', [$fromDate, $toDate])
    //             ->get();
    
    //         $imports = StockItem::with('product')
    //             ->whereBetween('created_at', [$fromDate, $toDate])
    //             ->get();
    //     }
    
    //     return view('report.index', compact('dispatches', 'imports', 'from', 'to'));
    // }

    // public function export(Request $request)
    // {
    //     $from = $request->input('from');
    //     $to = $request->input('to');

    //     $dispatches = DispatchTransaction::with('product')
    //         ->whereBetween('created_at', [$from, $to])
    //         ->get();

    //     $data = $dispatches->map(function ($d) {
    //         return [
    //             'UPC' => $d->product->upc ?? '-',
    //             'Style' => $d->product->style_name ?? '-',
    //             'Color' => $d->product->color ?? '-',
    //             'Size' => $d->product->size ?? '-',
    //             'Location' => $d->location,
    //             'Quantity' => $d->quantity,
    //             'Date' => $d->created_at->format('Y-m-d'),
    //         ];
    //     });

    //     return Excel::download(new ArrayExport($data), 'dispatch_report.xlsx');
    // }
}




?>