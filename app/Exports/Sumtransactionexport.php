<?php

namespace App\Exports;

use App\Model\Transaction ;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Facades\Excel;

class SumTransactionExport implements FromQuery,WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Transaction::query();
    }

    public function sheets(): array
    {
        $sheets = [];
        $sheets[]= new Totaltransactionexport();
        $sheets[] = new TransactionExport();
        return $sheets;
    }
}
