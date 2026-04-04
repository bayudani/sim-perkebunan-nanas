<?php

namespace App\Http\Controllers;

use App\Models\BiayaOperasional;
use App\Models\Pendapatan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter bulan & tahun dari request, jika kosong pakai bulan/tahun sekarang
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        // Ambil data Pemasukan (Pendapatan) sesuai bulan dan tahun
        $pemasukans = Pendapatan::with('hasilPanen')
                        ->whereMonth('tanggal', $bulan)
                        ->whereYear('tanggal', $tahun)
                        ->orderBy('tanggal', 'asc')
                        ->get();

        // Ambil data Pengeluaran (Biaya Operasional) sesuai bulan dan tahun
        $pengeluarans = BiayaOperasional::whereMonth('tanggal', $bulan)
                        ->whereYear('tanggal', $tahun)
                        ->orderBy('tanggal', 'asc')
                        ->get();

        // Kalkulasi Total
        $totalPemasukan = $pemasukans->sum('total_pendapatan');
        $totalPengeluaran = $pengeluarans->sum('jumlah');
        $saldo = $totalPemasukan - $totalPengeluaran;

        // Array nama bulan untuk dropdown
        $namaBulan = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        return view('laporan.index', compact(
            'pemasukans', 'pengeluarans', 'totalPemasukan', 
            'totalPengeluaran', 'saldo', 'bulan', 'tahun', 'namaBulan'
        ));
    }

    public function cetak(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $pemasukans = Pendapatan::with('hasilPanen')
                        ->whereMonth('tanggal', $bulan)
                        ->whereYear('tanggal', $tahun)
                        ->get();

        $pengeluarans = BiayaOperasional::whereMonth('tanggal', $bulan)
                        ->whereYear('tanggal', $tahun)
                        ->get();

        $totalPemasukan = $pemasukans->sum('total_pendapatan');
        $totalPengeluaran = $pengeluarans->sum('jumlah');
        $saldo = $totalPemasukan - $totalPengeluaran;

        $namaBulan = Carbon::createFromFormat('m', $bulan)->translatedFormat('F');

        // Load view PDF dan passing data
        $pdf = Pdf::loadView('laporan.pdf', compact(
            'pemasukans', 'pengeluarans', 'totalPemasukan', 
            'totalPengeluaran', 'saldo', 'namaBulan', 'tahun'
        ));

        // Return file PDF untuk didownload
        return $pdf->download('Laporan_Keuangan_Nanas_'.$namaBulan.'_'.$tahun.'.pdf');
    }
}