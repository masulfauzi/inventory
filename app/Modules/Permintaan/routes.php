<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Permintaan\Controllers\PermintaanController;

Route::controller(PermintaanController::class)->middleware(['web','auth'])->name('permintaan.')->group(function(){
	Route::get('/permintaan', 'index')->name('index');
	Route::get('/permintaan/data', 'data')->name('data.index');
	Route::get('/permintaan/create', 'create')->name('create');
	Route::post('/permintaan', 'store')->name('store');
	Route::get('/permintaan/{permintaan}', 'show')->name('show');
	Route::get('/permintaan/{permintaan}/edit', 'edit')->name('edit');
	Route::patch('/permintaan/{permintaan}', 'update')->name('update');
	Route::get('/permintaan/{permintaan}/delete', 'destroy')->name('destroy');
});