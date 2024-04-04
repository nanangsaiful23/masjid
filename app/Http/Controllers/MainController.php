<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Model\Muzakki;
use App\Model\Transaction;
use App\Model\TransactionDetail;
use App\Model\Zakat;

class MainController extends Controller
{
    public function index()
    {
        $muzakkis = Muzakki::orderBy('name','asc')->get();
        $zakats = Zakat::orderBy('name','asc')->get();

        $transactions = Transaction::get();

        $names = [];
        foreach($transactions as $transaction)
        {
            $name = '';
            foreach($transaction->TransactionDetail as $detail)
            {
                $name .= $detail->muzakki->name . ', ';
            }
            array_push($names, $name);
        }

        return view("index", compact('muzakkis', 'zakats', 'names'));
    }

    public function getGroup($name)
    {
        $muzakki = Muzakki::where('name', $name)->first();

        $transaction_detail = TransactionDetail::where('muzakki_id', $muzakki->id)
                                               ->orderBy('id', 'desc')->first();

        $groups = TransactionDetail::select('muzakkis.name')
                                   ->join('muzakkis', 'muzakkis.id', 'transaction_details.muzakki_id')
                                    ->where('transaction_details.transaction_id', $transaction_detail->transaction_id)
                                    ->where('transaction_details.muzakki_id', '!=', $muzakki->id)
                                    ->get();

        return response()->json([
            "groups"  => $groups,
        ], 200);
    }
}
