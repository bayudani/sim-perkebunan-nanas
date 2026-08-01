<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BiayaOperasionalController;
use App\Http\Controllers\HasilPanenController;
use App\Http\Controllers\PendapatanController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\PekerjaController;
use App\Http\Controllers\PerawatanController;
use App\Http\Controllers\RiwayatBudidayaController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Modul CRUD 
    Route::resource('biaya-operasional', BiayaOperasionalController::class);
    Route::resource('hasil-panen', HasilPanenController::class);
    Route::resource('pendapatan', PendapatanController::class);
    Route::resource('pekerja', PekerjaController::class);
    Route::resource('perawatan', PerawatanController::class);
    Route::resource('riwayat-budidaya', RiwayatBudidayaController::class);

    // Laporan Keuangan
    Route::get('/laporan', [LaporanKeuanganController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanKeuanganController::class, 'cetak'])->name('laporan.cetak');

    // Profile 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';