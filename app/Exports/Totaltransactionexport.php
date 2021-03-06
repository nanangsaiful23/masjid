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
        $ringkasan = Transaction::groupBy('jenis','jenis_pembayaran')
            ->selectRaw('jenis, jenis_pembayaran ,sum(nominal) as total')
            ->get();
        $totalringkasan=Transaction::groupBy('jenis_pembayaran')
                                    ->selectRaw('jenis_pembayaran ,sum(nominal) as total')
                                    ->get();
        for ($i=0 ; $i < sizeof($totalringkasan)  ; $i++ ) {
            $totalringkasan[$i]->jenis_pembayaran ="Total " . $totalringkasan[$i]->jenis_pembayaran;
        }
        $ringkasan = $ringkasan->toBase()->merge($totalringkasan);
        return  $ringkasan;
    }
    public function headings(): array
    {
        return [ "Jenis","Jenis Pembayaran", "Nominal"];
    }
    public function title(): string
    {
        return 'Ringkasan data';
    }
}
