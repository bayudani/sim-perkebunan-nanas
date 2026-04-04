<?php

namespace App\Http\Controllers;

use App\Models\Pendapatan;
use App\Models\HasilPanen;
use Illuminate\Http\Request;

class PendapatanController extends Controller
{
    public function index()
    {
        // Mengambil semua data pendapatan beserta relasi user dan data panennya
        $pendapatans = Pendapatan::with(['user', 'hasilPanen'])->orderBy('tanggal', 'desc')->get();
        
        // Menghitung total seluruh pendapatan
        $totalPendapatan = $pendapatans->sum('total_pendapatan');

        return view('pendapatan.index', compact('pendapatans', 'totalPendapatan'));
    }

    public function create()
    {
        //  Hanya Admin yang boleh tambah data
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses Ditolak. Hanya Admin yang dapat menambah data.');
        }

        // Mengambil data hasil panen untuk ditampilkan di dropdown pilihan form
        $hasilPanens = HasilPanen::orderBy('tanggal_panen', 'desc')->get();

        return view('pendapatan.form', compact('hasilPanens'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $request->validate([
            'tanggal' => 'required|date',
            'hasil_panen_id' => 'required|exists:hasil_panens,id',
            'harga_per_kg' => 'required|numeric|min:0',
            'total_pendapatan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Pendapatan::create([
            'tanggal' => $request->tanggal,
            'hasil_panen_id' => $request->hasil_panen_id,
            'harga_per_kg' => $request->harga_per_kg,
            'total_pendapatan' => $request->total_pendapatan,
            'keterangan' => $request->keterangan,
            'user_id' => auth()->id(), 
        ]);

        return redirect()->route('pendapatan.index')->with('success', 'Data pendapatan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $pendapatan = Pendapatan::findOrFail($id);
        $hasilPanens = HasilPanen::orderBy('tanggal_panen', 'desc')->get();
        
        return view('pendapatan.form', compact('pendapatan', 'hasilPanens'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $request->validate([
            'tanggal' => 'required|date',
            'hasil_panen_id' => 'required|exists:hasil_panens,id',
            'harga_per_kg' => 'required|numeric|min:0',
            'total_pendapatan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $pendapatan = Pendapatan::findOrFail($id);
        $pendapatan->update([
            'tanggal' => $request->tanggal,
            'hasil_panen_id' => $request->hasil_panen_id,
            'harga_per_kg' => $request->harga_per_kg,
            'total_pendapatan' => $request->total_pendapatan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pendapatan.index')->with('success', 'Data pendapatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $pendapatan = Pendapatan::findOrFail($id);
        $pendapatan->delete();

        return redirect()->route('pendapatan.index')->with('success', 'Data pendapatan berhasil dihapus!');
    }
}