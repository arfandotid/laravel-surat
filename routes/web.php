<?php

use App\Http\Controllers\JenisSuratController;
use App\Http\Controllers\SuratController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::resource('jenis_surat', JenisSuratController::class);

Route::post('surat/preview', [SuratController::class, 'preview'])->name('surat.preview');
Route::resource('surat', SuratController::class);
