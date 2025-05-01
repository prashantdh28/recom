<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ErrorProductListExport implements FromCollection, WithHeadings
{
    private $rows = [];
    public function __construct($row)
    {
        $this->rows = $row;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->rows);
    }

    public function headings(): array
    {
        return [
            'Brand', 'Product Name', 'Product Status', 'GTIN', 'SKU', 'ASIN', "Error"
        ];
    }
}
