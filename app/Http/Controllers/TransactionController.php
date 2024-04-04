<?php

namespace App\Http\Controllers;

use App\Exports\SumTransactionExport;
use App\Exports\TransactionExport;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Model\Muzakki;
use App\Model\Transaction;
use App\Model\TransactionDetail;
use App\Model\Zakat;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();

        return view('transaction', compact('transactions'));
    }

    public function tambah(Request $request)
    {
        $data= $request->input();

        $data_transaction['total_money'] = $request->total_uang;
        $data_transaction['total_rice'] = $request->total_beras;
        $transaction = Transaction::create($data_transaction);
            
        $data_transaction_detail['transaction_id'] = $transaction->id;

        for ($i = 0; $i < sizeof($data["nama"]); $i++) 
        {
            $muzakki = Muzakki::where('name', $data['nama'][$i])->first();

            if($muzakki == null)
            {
                $data_muzakki['name'] = $data['nama'][$i];

                $muzakki = Muzakki::create($data_muzakki);
            }
            
            $zakat = Zakat::where('name', $data['jenis'][$i])->first();
           
            $data_transaction_detail['muzakki_id'] = $muzakki->id;
            $data_transaction_detail['zakat_id'] = $zakat->id;
            $data_transaction_detail['nominal'] = $data['nominal'][$i];

            $transaction_detail = TransactionDetail::create($data_transaction_detail);
        }

        $totaluang  = number_format($request->total_uang,0,",",".");
        $totalberas = number_format($request->total_beras,1,",",".");

        return view("print_nota", compact("transaction", "totaluang", "totalberas"));
    }

    public function lihat($start_date, $end_date, $pagination)
    {
        $zakats = Zakat::leftjoin('transaction_details', function($join) use($start_date, $end_date) {
                            $join->on('transaction_details.zakat_id', '=', 'zakats.id')
                                 ->whereDate('transaction_details.created_at', '>=', $start_date)
                                 ->whereDate('transaction_details.created_at', '<=', $end_date); })
                       ->select('zakats.name', DB::raw('SUM(transaction_details.nominal) as nominal'), 'zakats.type')
                       ->groupBy('zakats.name', 'zakats.type')
                       ->get();

        if($pagination == 'all')
        {
            $transactions = Transaction::whereDate('created_at', '>=', $start_date)
                                    ->whereDate('created_at', '<=', $end_date)
                                    ->get();
        }
        else
        {
            $transactions = Transaction::whereDate('created_at', '>=', $start_date)
                                    ->whereDate('created_at', '<=', $end_date)
                                    ->paginate($pagination);
        }
        return view("lihatdata",compact('zakats', "transactions", "start_date", "end_date", "pagination"));
    }

	public function export_excel($start_date,$end_date)
	{
		return Excel::download(new TransactionExport($start_date,$end_date), 'Data_Muzakki.xlsx');
    }

    public function export_sumdata($start_date,$end_date)
    {
        return Excel::download(new SumTransactionExport($start_date,$end_date),"Dataringkasanmuzakki.xlsx");
    }

    function downloadmuzakki(){

        $table = Transaction::all();
        $filename = "data_muzakki.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('nama', 'jenis', 'nominal'));

        foreach($table as $row) {
            fputcsv($handle, array($row['nama'], $row['jenis'], $row['nominal']));
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return response()->download($filename, 'data_muzakki.csv', $headers);
    }

    public function import(Request $request)
    {
        if($request->hasFile('xlsx'))
        {
            $file = $request->file('xlsx')->store('datas');
        }
        $path = Storage::disk('local')->getDriver()->getAdapter()->applyPathPrefix($file);
        $items = Excel::toArray(function($reader) {}, $path);

        foreach ($items[0] as $item)
        {
            $data['nama'] = $item[0];
            $data['jenis'] = $item[1];
            $data['jenis_pembayaran'] = $item[2];
            $data['nominal'] = $item[3];
            $data['created_at'] = date('Y-m-d', strtotime('2020-05-19'));
            $data['updated_at'] = date('Y-m-d', strtotime('2020-05-19'));

            Transaction::create($data);
        }

        File::delete($path);

        return redirect('/laporan/'. date("Y-m-d") . '/' . date("Y-m-d") . '/20');
    }

    public function importMuzakki(Request $request)
    {
        if($request->hasFile('xlsx'))
        {
            $file = $request->file('xlsx')->store('datas');
        }
        $path = Storage::disk('local')->getDriver()->getAdapter()->applyPathPrefix($file);
        $items = Excel::toArray(function($reader) {}, $path);

        foreach ($items[0] as $item)
        {
            $data['name'] = $item[0];

            $muzakki = Muzakki::where('name', $data['name'])->first();

            if($muzakki == null)
                Muzakki::create($data);
        }

        File::delete($path);

        return redirect('/laporan/'. date("Y-m-d") . '/' . date("Y-m-d") . '/20');
    }

    public function print($transaction_id)
    {
        $transaction = Transaction::find($transaction_id);

        $totaluang  = number_format($transaction->total_money,0,",",".");
        $totalberas = number_format($transaction->total_rice,1,",",".");

        return view("print_nota", compact("transaction", "totaluang", "totalberas"));
    }
}
