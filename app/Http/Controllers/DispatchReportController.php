<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DispatchTransaction;
use Carbon\Carbon;

class DispatchReportController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $dispatches = DispatchTransaction::with('product')
            ->when($from && $to, function ($query) use ($from, $to) {
                $query->whereBetween('created_at', [
                    Carbon::parse($from)->startOfDay(),
                    Carbon::parse($to)->endOfDay()
                ]);
            })
            ->latest()
            ->paginate(15); // ✅ paginate

        return view('report.dispatch', compact('dispatches', 'from', 'to'));
    }
}

