<?php

namespace App\Http\Controllers;

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
            $totalbayar=0;
            for ($i=0; $i < sizeof($data["nama"]); $i++) {
                $temp["nama"]=$data["nama"][$i];
                $temp["jenis"]=$data["jenis"][$i];
                $temp["nominal"]=$data["nominal"][$i];
                $transactions[$i]=Transaction::create($temp);
                $totalbayar+=$data["nominal"][$i];
            }
            $totalbayar=number_format($totalbayar,0,",",".");
            return view("print_nota",compact("transactions","totalbayar"));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function lihat()
    {
        $ringkasan=Transaction::groupBy('jenis')
                                ->selectRaw('jenis, sum(nominal) as total')
                                ->get();
        return view("lihatdata",compact("ringkasan"));
    }
    public function index()
	{
		$siswa = Transaction::all();
		return view('siswa',['siswa'=>$siswa]);
	}

	public function export_excel()
	{
		return Excel::download(new TransactionExport, 'transaction.xlsx');
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
