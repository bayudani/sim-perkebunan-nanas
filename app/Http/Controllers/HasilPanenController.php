<?php

namespace App\Http\Controllers;

use App\Models\HasilPanen;
use App\Models\BiayaOperasional;
use Illuminate\Http\Request;

class HasilPanenController extends Controller
{
    public function index()
    {
        // Mengambil semua data hasil panen diurutkan dari yang terbaru
        $panens = HasilPanen::with(['user', 'pendapatans'])->orderBy('tanggal_panen', 'desc')->get();
        
        // Menghitung total jumlah panen
        $totalPanen = $panens->sum('jumlah_panen');

        // Total panen per blok/lahan (abaikan blok kosong)
        $totalPerBlok = $panens->filter(fn($item) => !empty($item->blok_lahan))
            ->groupBy('blok_lahan')
            ->map(fn($items) => $items->sum('jumlah_panen'))
            ->sortDesc();

        // Pendapatan per blok (dari penjualan yang tercatat pada hasil panen)
        $pendapatanPerBlok = $panens->filter(fn($item) => !empty($item->blok_lahan))
            ->groupBy('blok_lahan')
            ->map(fn($items) => $items->flatMap(fn($item) => $item->pendapatans)->sum('total_pendapatan'));

        // Biaya operasional per blok (dari kolom blok_lahan, fallback blok perawatan)
        $biayaPerBlok = BiayaOperasional::with('perawatan')->get()
            ->filter(fn($biaya) => $biaya->blok_lahan ?? $biaya->perawatan->blok_lahan ?? null)
            ->groupBy(fn($biaya) => $biaya->blok_lahan ?? $biaya->perawatan->blok_lahan)
            ->map(fn($items) => $items->sum('jumlah'));

        return view('hasil-panen.index', compact(
            'panens', 'totalPanen', 'totalPerBlok', 'pendapatanPerBlok', 'biayaPerBlok'
        ));
    }

    public function create()
    {
        //  Hanya Admin yang boleh tambah data
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses Ditolak. Hanya Admin yang dapat menambah data.');
        }

        return view('hasil-panen.form');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $request->validate([
            'tanggal_panen' => 'required|date',
            'blok_lahan' => 'required|string|max:100',
            'jumlah_panen' => 'required|numeric|min:1',
            'jumlah_terjual' => 'required|numeric|min:0',
            'kualitas' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:255',
        ]);

        HasilPanen::create([
            'tanggal_panen' => $request->tanggal_panen,
            'blok_lahan' => $request->blok_lahan,
            'jumlah_panen' => $request->jumlah_panen,
            'jumlah_terjual' => $request->jumlah_terjual,
            'kualitas' => $request->kualitas,
            'keterangan' => $request->keterangan,
            'user_id' => auth()->id(), 
        ]);

        return redirect()->route('hasil-panen.index')->with('success', 'Data hasil panen berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $panen = HasilPanen::findOrFail($id);
        return view('hasil-panen.form', compact('panen'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $request->validate([
            'tanggal_panen' => 'required|date',
            'blok_lahan' => 'required|string|max:100',
            'jumlah_panen' => 'required|numeric|min:1',
            'jumlah_terjual' => 'required|numeric|min:0',
            'kualitas' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $panen = HasilPanen::findOrFail($id);
        $panen->update([
            'tanggal_panen' => $request->tanggal_panen,
            'blok_lahan' => $request->blok_lahan,
            'jumlah_panen' => $request->jumlah_panen,
            'jumlah_terjual' => $request->jumlah_terjual,
            'kualitas' => $request->kualitas,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('hasil-panen.index')->with('success', 'Data hasil panen berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $panen = HasilPanen::findOrFail($id);
        $panen->delete();

        return redirect()->route('hasil-panen.index')->with('success', 'Data hasil panen berhasil dihapus!');
    }
}