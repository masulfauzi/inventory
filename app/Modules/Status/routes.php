<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Status\Controllers\StatusController;

Route::controller(StatusController::class)->middleware(['web','auth'])->name('status.')->group(function(){
	Route::get('/status', 'index')->name('index');
	Route::get('/status/data', 'data')->name('data.index');
	Route::get('/status/create', 'create')->name('create');
	Route::post('/status', 'store')->name('store');
	Route::get('/status/{status}', 'show')->name('show');
	Route::get('/status/{status}/edit', 'edit')->name('edit');
	Route::patch('/status/{status}', 'update')->name('update');
	Route::get('/status/{status}/delete', 'destroy')->name('destroy');
});