<?php

Route::get('/',  'MainController@index');
Route::post('/storeExcel', 'TransactionController@import')->name('storeExcel');
Route::post('/importMuzakki', 'TransactionController@importMuzakki');
Route::post('/transaksi', 'TransactionController@tambah')->name('transaksi');
Route::get('/laporan/{start_date}/{end_date}/{pagination}', 'TransactionController@lihat')->name('laporan');

Route::get('/all-tweets-csv', "TransactionController@downloadmuzakki");
Route::get('/transation', 'TransactionController@index');
Route::get('/print/{transation_id}', 'TransactionController@print');
Route::delete('/transaction/{transation_id}/delete', 'TransactionController@delete');
Route::get('/transaction/export_excel/{start_date}/{end_date}', 'TransactionController@export_excel');

// Route::get('/transaction/export_excel', 'TransactionController@export_excel');
Route::get('/export_sumdata/{start_date}/{end_date}','TransactionController@export_sumdata');

Route::get('/getGroup/{name}',  'MainController@getGroup');

