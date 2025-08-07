<?php

// app/Exports/ArrayExport.php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ArrayExport implements FromCollection
{
    protected $rows;

    public function __construct($rows)
    {
        $this->rows = collect($rows);
    }

    public function collection()
    {
        return $this->rows;
    }
}
