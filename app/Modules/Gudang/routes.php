<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Gudang\Controllers\GudangController;

Route::controller(GudangController::class)->middleware(['web','auth'])->name('gudang.')->group(function(){
	Route::get('/gudang', 'index')->name('index');
	Route::get('/gudang/data', 'data')->name('data.index');
	Route::get('/gudang/create', 'create')->name('create');
	Route::post('/gudang', 'store')->name('store');
	Route::get('/gudang/{gudang}', 'show')->name('show');
	Route::get('/gudang/{gudang}/edit', 'edit')->name('edit');
	Route::patch('/gudang/{gudang}', 'update')->name('update');
	Route::get('/gudang/{gudang}/delete', 'destroy')->name('destroy');
});