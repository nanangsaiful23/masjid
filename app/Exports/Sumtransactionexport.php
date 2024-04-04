<?php

namespace App\Exports;

use App\Model\Zakat;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class SumTransactionExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $start_date;
    protected $end_date;
    public function __construct(string $start_date,string $end_date){
        
        $this->start_date=$start_date;
        $this->end_date=$end_date;
    }
    
    public function collection()
    {
        $start = $this->start_date;
        $end   = $this->end_date;

        $zakats = Zakat::leftjoin('transaction_details', function($join) use($start, $end) {
                            $join->on('transaction_details.zakat_id', '=', 'zakats.id')
                                 ->whereDate('transaction_details.created_at', '>=', $start)
                                 ->whereDate('transaction_details.created_at', '<=', $end); })
                       ->select('zakats.name', DB::raw('SUM(transaction_details.nominal) as nominal'))
                       ->groupBy('zakats.name', 'zakats.type')
                       ->get();

        return $zakats;
    }

    public function headings(): array
    {
        return ["Nama", "Nominal"];
    }
    
    public function title(): string
    {
        return 'Data Ringkasan Zakat';
    }
}
