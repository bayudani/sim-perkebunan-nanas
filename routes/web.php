<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BiayaOperasionalController;
use App\Http\Controllers\HasilPanenController;
use App\Http\Controllers\PendapatanController;
use App\Http\Controllers\LaporanKeuanganController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('biaya-operasional', BiayaOperasionalController::class);
Route::resource('hasil-panen', HasilPanenController::class);
Route::resource('pendapatan', PendapatanController::class);

Route::get('/laporan', [LaporanKeuanganController::class, 'index'])->name('laporan.index');
Route::get('/laporan/cetak', [LaporanKeuanganController::class, 'cetak'])->name('laporan.cetak');

require __DIR__.'/auth.php';
