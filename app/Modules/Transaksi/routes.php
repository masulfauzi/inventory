<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Transaksi\Controllers\TransaksiController;

Route::controller(TransaksiController::class)->middleware(['web','auth'])->name('transaksi.')->group(function(){
	Route::get('/transaksi', 'index')->name('index');
	Route::get('/transaksi/data', 'data')->name('data.index');
	Route::get('/transaksi/create', 'create')->name('create');
	Route::post('/transaksi', 'store')->name('store');
	Route::get('/transaksi/{transaksi}', 'show')->name('show');
	Route::get('/transaksi/{transaksi}/edit', 'edit')->name('edit');
	Route::patch('/transaksi/{transaksi}', 'update')->name('update');
	Route::get('/transaksi/{transaksi}/delete', 'destroy')->name('destroy');
});