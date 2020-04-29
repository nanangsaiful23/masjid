<?php

use App\Model\Transaction;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::post('/transaksi', 'TransactionController@tambah')->name('transaksi');
Route::get('/laporan', 'TransactionController@lihat')->name('laporan');

Route::get('/all-tweets-csv', "TransactionController@downloadmuzakki");
