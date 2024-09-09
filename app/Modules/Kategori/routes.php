<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Kategori\Controllers\KategoriController;

Route::controller(KategoriController::class)->middleware(['web','auth'])->name('kategori.')->group(function(){
	Route::get('/kategori', 'index')->name('index');
	Route::get('/kategori/data', 'data')->name('data.index');
	Route::get('/kategori/create', 'create')->name('create');
	Route::post('/kategori', 'store')->name('store');
	Route::get('/kategori/{kategori}', 'show')->name('show');
	Route::get('/kategori/{kategori}/edit', 'edit')->name('edit');
	Route::patch('/kategori/{kategori}', 'update')->name('update');
	Route::get('/kategori/{kategori}/delete', 'destroy')->name('destroy');
});