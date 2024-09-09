<?php

use Illuminate\Support\Facades\Route;
use App\Modules\BarangPermintaan\Controllers\BarangPermintaanController;

Route::controller(BarangPermintaanController::class)->middleware(['web','auth'])->name('barangpermintaan.')->group(function(){
	Route::get('/barangpermintaan', 'index')->name('index');
	Route::get('/barangpermintaan/data', 'data')->name('data.index');
	Route::get('/barangpermintaan/create', 'create')->name('create');
	Route::post('/barangpermintaan', 'store')->name('store');
	Route::get('/barangpermintaan/{barangpermintaan}', 'show')->name('show');
	Route::get('/barangpermintaan/{barangpermintaan}/edit', 'edit')->name('edit');
	Route::patch('/barangpermintaan/{barangpermintaan}', 'update')->name('update');
	Route::get('/barangpermintaan/{barangpermintaan}/delete', 'destroy')->name('destroy');
});