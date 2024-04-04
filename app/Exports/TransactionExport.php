<?php

namespace App\Exports;

use App\Model\TransactionDetail;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Facades\Excel;

class TransactionExport implements FromCollection, WithHeadings, WithTitle
{
    protected $start_date;
    protected $end_date;
    public function __construct(string $start_date,string $end_date){
        
        $this->start_date=$start_date;
        $this->end_date=$end_date;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $transaction = TransactionDetail::join('muzakkis', 'muzakkis.id', 'transaction_details.muzakki_id')
                                        ->join('zakats', 'zakats.id', 'transaction_details.zakat_id')
                                        ->select('muzakkis.name as nama', 'zakats.name as jenis', 'zakats.type as jenis_pembayaran', 'transaction_details.nominal as nominal')
                                        ->whereDate('transaction_details.created_at', '>=', $this->start_date)
                                        ->whereDate('transaction_details.created_at', '<=',$this->end_date)
                                        ->get();
        return $transaction;
    }

    public function headings(): array
    {
        return ["Nama", "Jenis", "Jenis Pembayaran", "Nominal"];
    }

    public function title(): string
    {
        return 'Data Muzakki';
    }

    public function array(): array
    {
        return $this->start_date;
    }
}
