<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Satuan\Controllers\SatuanController;

Route::controller(SatuanController::class)->middleware(['web','auth'])->name('satuan.')->group(function(){
	Route::get('/satuan', 'index')->name('index');
	Route::get('/satuan/data', 'data')->name('data.index');
	Route::get('/satuan/create', 'create')->name('create');
	Route::post('/satuan', 'store')->name('store');
	Route::get('/satuan/{satuan}', 'show')->name('show');
	Route::get('/satuan/{satuan}/edit', 'edit')->name('edit');
	Route::patch('/satuan/{satuan}', 'update')->name('update');
	Route::get('/satuan/{satuan}/delete', 'destroy')->name('destroy');
});