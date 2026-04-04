<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BiayaOperasional;
use App\Models\HasilPanen;
use App\Models\Pendapatan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Total Keseluruhan
        $totalBiaya = BiayaOperasional::sum('jumlah');
        $totalPanen = HasilPanen::sum('jumlah_panen');
        $totalPendapatan = Pendapatan::sum('total_pendapatan');
        $saldo = $totalPendapatan - $totalBiaya;

        // 2. Ambil Aktivitas Terbaru (Gabungan 5 Pengeluaran dan 5 Pemasukan Terakhir)
        $biayaRecent = BiayaOperasional::latest('tanggal')->take(5)->get()->map(function($item) {
            return (object) [
                'jenis' => 'Pengeluaran',
                'deskripsi' => $item->jenis_biaya,
                'tanggal' => $item->tanggal,
                'nominal' => $item->jumlah
            ];
        });

        $pendapatanRecent = Pendapatan::with('hasilPanen')->latest('tanggal')->take(5)->get()->map(function($item) {
            return (object) [
                'jenis' => 'Pemasukan',
                'deskripsi' => 'Penjualan Nanas ' . ($item->hasilPanen ? '('.$item->hasilPanen->kualitas.')' : ''),
                'tanggal' => $item->tanggal,
                'nominal' => $item->total_pendapatan
            ];
        });

        // Gabungkan, urutkan berdasarkan tanggal terbaru, lalu ambil 5 teratas
        $aktivitasTerbaru = $biayaRecent->concat($pendapatanRecent)->sortByDesc('tanggal')->take(5);

        // 3. Persiapkan Data untuk Grafik (Bulan 1 s/d 12 Tahun Berjalan)
        $tahunIni = date('Y');
        $chartPemasukan = [];
        $chartPengeluaran = [];

        for($i = 1; $i <= 12; $i++) {
            $chartPemasukan[] = Pendapatan::whereYear('tanggal', $tahunIni)->whereMonth('tanggal', $i)->sum('total_pendapatan');
            $chartPengeluaran[] = BiayaOperasional::whereYear('tanggal', $tahunIni)->whereMonth('tanggal', $i)->sum('jumlah');
        }

        // Return ke view
        return view('dashboard', compact(
            'totalBiaya', 'totalPanen', 'totalPendapatan', 'saldo', 
            'aktivitasTerbaru', 'chartPemasukan', 'chartPengeluaran', 'tahunIni'
        ));
    }
}