<?php

use Illuminate\Support\Facades\Route;
use App\Modules\UserGudang\Controllers\UserGudangController;

Route::controller(UserGudangController::class)->middleware(['web','auth'])->name('usergudang.')->group(function(){
	Route::get('/usergudang', 'index')->name('index');
	Route::get('/usergudang/data', 'data')->name('data.index');
	Route::get('/usergudang/create', 'create')->name('create');
	Route::post('/usergudang', 'store')->name('store');
	Route::get('/usergudang/{usergudang}', 'show')->name('show');
	Route::get('/usergudang/{usergudang}/edit', 'edit')->name('edit');
	Route::patch('/usergudang/{usergudang}', 'update')->name('update');
	Route::get('/usergudang/{usergudang}/delete', 'destroy')->name('destroy');
});