<?php

namespace App\Http\Controllers;

use App\Models\HasilPanen;
use Illuminate\Http\Request;

class HasilPanenController extends Controller
{
    public function index()
    {
        // Mengambil semua data hasil panen diurutkan dari yang terbaru
        $panens = HasilPanen::with('user')->orderBy('tanggal_panen', 'desc')->get();
        
        // Menghitung total jumlah panen
        $totalPanen = $panens->sum('jumlah_panen');

        return view('hasil-panen.index', compact('panens', 'totalPanen'));
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
            'jumlah_panen' => 'required|numeric|min:1',
            'jumlah_terjual' => 'required|numeric|min:0',
            'kualitas' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:255',
        ]);

        HasilPanen::create([
            'tanggal_panen' => $request->tanggal_panen,
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
            'jumlah_panen' => 'required|numeric|min:1',
            'jumlah_terjual' => 'required|numeric|min:0',
            'kualitas' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $panen = HasilPanen::findOrFail($id);
        $panen->update([
            'tanggal_panen' => $request->tanggal_panen,
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