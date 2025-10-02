<?php

use App\Http\Controllers\JenisSuratController;
use App\Http\Controllers\SuratController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('jenis_surat', JenisSuratController::class);
    Route::post('surat/preview', [SuratController::class, 'preview'])->name('surat.preview');
    Route::resource('surat', SuratController::class);
});

Auth::routes();
