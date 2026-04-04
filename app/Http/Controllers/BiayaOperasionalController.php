<?php

namespace App\Http\Controllers;

use App\Models\BiayaOperasional;
use Illuminate\Http\Request;

class BiayaOperasionalController extends Controller
{
    public function index()
    {
        // Mengambil semua data biaya operasional diurutkan dari yang terbaru
        $biayas = BiayaOperasional::with('user')->orderBy('tanggal', 'desc')->get();
        
        // Menghitung total biaya operasional
        $totalBiaya = $biayas->sum('jumlah');

        return view('biaya-operasional.index', compact('biayas', 'totalBiaya'));
    }

    public function create()
    {
        // Proteksi: Hanya Admin yang boleh tambah data
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses Ditolak. Hanya Admin yang dapat menambah data.');
        }

        return view('biaya-operasional.form');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $request->validate([
            'tanggal' => 'required|date',
            'jenis_biaya' => 'required|string|max:50',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        BiayaOperasional::create([
            'tanggal' => $request->tanggal,
            'jenis_biaya' => $request->jenis_biaya,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'user_id' => auth()->id(), // Otomatis simpan ID user yang login
        ]);

        return redirect()->route('biaya-operasional.index')->with('success', 'Data biaya operasional berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $biaya = BiayaOperasional::findOrFail($id);
        return view('biaya-operasional.form', compact('biaya'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $request->validate([
            'tanggal' => 'required|date',
            'jenis_biaya' => 'required|string|max:50',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $biaya = BiayaOperasional::findOrFail($id);
        $biaya->update([
            'tanggal' => $request->tanggal,
            'jenis_biaya' => $request->jenis_biaya,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            // user_id tidak diubah agar ketahuan siapa pembuat awalnya
        ]);

        return redirect()->route('biaya-operasional.index')->with('success', 'Data biaya operasional berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $biaya = BiayaOperasional::findOrFail($id);
        $biaya->delete();

        return redirect()->route('biaya-operasional.index')->with('success', 'Data berhasil dihapus!');
    }
}