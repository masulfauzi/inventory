<?php

use Illuminate\Support\Facades\Route;
use App\Modules\BarangGudang\Controllers\BarangGudangController;


Route::controller(BarangGudangController::class)->middleware(['web','auth'])->name('baranggudang.')->group(function(){
	Route::get('/baranggudang/transaksi', 'transaksi')->name('transaksi.show');
	Route::get('/baranggudang/laporan', 'laporan_barang')->name('laporan.show');
	
	Route::get('/baranggudang', 'index')->name('index');
	Route::get('/baranggudang/data', 'data')->name('data.index');
	Route::get('/baranggudang/create', 'create')->name('create');
	Route::post('/baranggudang', 'store')->name('store');
	Route::get('/baranggudang/{baranggudang}', 'show')->name('show');
	Route::get('/baranggudang/{baranggudang}/edit', 'edit')->name('edit');
	Route::patch('/baranggudang/{baranggudang}', 'update')->name('update');
	Route::get('/baranggudang/{baranggudang}/delete', 'destroy')->name('destroy');
});