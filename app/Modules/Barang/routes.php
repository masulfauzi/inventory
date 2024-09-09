<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Barang\Controllers\BarangController;

Route::controller(BarangController::class)->middleware(['web','auth'])->name('barang.')->group(function(){
	Route::get('/barang', 'index')->name('index');
	Route::get('/barang/data', 'data')->name('data.index');
	Route::get('/barang/create', 'create')->name('create');
	Route::post('/barang', 'store')->name('store');
	Route::get('/barang/{barang}', 'show')->name('show');
	Route::get('/barang/{barang}/edit', 'edit')->name('edit');
	Route::patch('/barang/{barang}', 'update')->name('update');
	Route::get('/barang/{barang}/delete', 'destroy')->name('destroy');
});