<?php

namespace App\Http\Controllers;

use App\Exports\DispatchExport;
use Illuminate\Http\Request;
use App\Imports\StockDispatchImport;
use Maatwebsite\Excel\Facades\Excel;

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

}

