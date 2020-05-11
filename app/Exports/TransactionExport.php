<?php

namespace App\Exports;

use App\Model\Transaction ;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Facades\Excel;

class TransactionExport implements FromCollection ,WithHeadings,WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Transaction::all();
    }
    public function headings(): array
    {
        return ["no","Nama", "Jenis", "Nominal"];
    }
    public function title(): string
    {
        return 'Data Muzakki';
    }
}
