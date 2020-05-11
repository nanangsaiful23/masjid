<?php

namespace App\Exports;

use App\Model\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Facades\Excel;

class TotaltransactionExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $ringkasan = Transaction::groupBy('jenis')
            ->selectRaw('jenis, sum(nominal) as total')
            ->get();
        $totalringkasan=Transaction::selectRaw('sum(nominal) as jenis,sum(nominal) as total')
                        ->get();
        $totalringkasan[0]->jenis="TOTAL";
        $ringkasan = $ringkasan->toBase()->merge($totalringkasan);
        return  $ringkasan;
    }
    public function headings(): array
    {
        return [ "Jenis", "Nominal"];
    }
    public function title(): string
    {
        return 'Ringkasan data';
    }
}
