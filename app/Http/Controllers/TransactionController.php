<?php

namespace App\Http\Controllers;

use App\Exports\SumTransactionExport;
use App\Exports\TransactionExport;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Model\Transaction;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    public function tambah(Request $request)
    {
        try {
            $data= $request->input();
            // dd($data);die;
            $transactions=[];
            $totaluang=0;
            $totalberas=0;
            for ($i=0; $i < sizeof($data["nama"]); $i++) {
                $temp["nama"]=$data["nama"][$i];
                $temp["jenis"]=$data["jenis"][$i];
                $temp["jenis_pembayaran"]=$data["jenis_pembayaran"][$i];
                $temp["nominal"]=$data["nominal"][$i];
                $transactions[$i]=Transaction::create($temp);
                if ($temp["jenis_pembayaran"]=="Uang") {
                    $totaluang+=$data["nominal"][$i];
                }else if($temp["jenis_pembayaran"]=="Beras"){
                    $totalberas+=$data["nominal"][$i];
                }

            }
            $totaluang=number_format($totaluang,1,",",".");
            $totalberas=number_format($totalberas,1,",",".");
            return view("print_nota",compact("transactions","totaluang","totalberas"));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function lihat()
    {
        $ringkasan=Transaction::groupBy('jenis','jenis_pembayaran')
                                ->selectRaw('jenis, sum(nominal) as total, jenis_pembayaran')
                                ->get();
        return view("lihatdata",compact("ringkasan"));
    }
    public function index()
	{
		$siswa = Transaction::all();
		return view('transaction',['transaction'=>$siswa]);
	}

	public function export_excel()
	{
		return Excel::download(new TransactionExport, 'Data_Muzakki.xlsx');
    }
    public function export_sumdata()
    {
        return Excel::download(new SumTransactionExport,"Dataringkasanmuzakki.xlsx");
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
}
