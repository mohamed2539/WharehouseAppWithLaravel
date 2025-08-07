<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DispatchExport implements FromCollection, WithHeadings //FromView
{
    protected $from;
    protected $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }




    public function headings(): array
    {
        return [
            'UPC',
            'Style',
            'Color',
            'Size',
            'Location',
            'Quantity',
            'Date',
        ];
    }

    public function view(): View
    {
        $dispatches = \App\Models\DispatchTransaction::with('product')
            ->whereBetween('created_at', [
                \Carbon\Carbon::parse($this->from)->startOfDay(),
                \Carbon\Carbon::parse($this->to)->endOfDay()
            ])
            ->latest()
            ->get();

        return view('exports.dispatch', ['dispatches' => $dispatches]);
    }
}


