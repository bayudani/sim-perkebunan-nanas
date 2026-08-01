<?php

namespace App\Http\Controllers;

use App\Models\RiwayatBudidaya;
use App\Models\Pekerja;
use Illuminate\Http\Request;

class RiwayatBudidayaController extends Controller
{
    public function index()
    {
        $riwayats = RiwayatBudidaya::with(['user', 'pekerjas'])->orderBy('tanggal', 'desc')->get();

        return view('riwayat-budidaya.index', compact('riwayats'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses Ditolak. Hanya Admin yang dapat menambah data.');
        }

        $pekerjas = Pekerja::orderBy('nama', 'asc')->get();

        return view('riwayat-budidaya.form', compact('pekerjas'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $request->validate([
            'tanggal' => 'required|date',
            'jenis_kegiatan' => 'required|string|max:50',
            'blok_lahan' => 'required|string|max:100',
            'pekerja_ids' => 'nullable|array',
            'pekerja_ids.*' => 'exists:pekerjas,id',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $riwayat = RiwayatBudidaya::create([
            'tanggal' => $request->tanggal,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'blok_lahan' => $request->blok_lahan,
            'keterangan' => $request->keterangan,
            'user_id' => auth()->id(),
        ]);

        if ($request->filled('pekerja_ids')) {
            $riwayat->pekerjas()->attach($request->pekerja_ids);
        }

        return redirect()->route('riwayat-budidaya.index')->with('success', 'Riwayat budidaya berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $riwayat = RiwayatBudidaya::with('pekerjas')->findOrFail($id);
        $pekerjas = Pekerja::orderBy('nama', 'asc')->get();

        return view('riwayat-budidaya.form', compact('riwayat', 'pekerjas'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $request->validate([
            'tanggal' => 'required|date',
            'jenis_kegiatan' => 'required|string|max:50',
            'blok_lahan' => 'required|string|max:100',
            'pekerja_ids' => 'nullable|array',
            'pekerja_ids.*' => 'exists:pekerjas,id',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $riwayat = RiwayatBudidaya::findOrFail($id);
        $riwayat->update([
            'tanggal' => $request->tanggal,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'blok_lahan' => $request->blok_lahan,
            'keterangan' => $request->keterangan,
        ]);

        $riwayat->pekerjas()->sync($request->pekerja_ids ?? []);

        return redirect()->route('riwayat-budidaya.index')->with('success', 'Riwayat budidaya berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $riwayat = RiwayatBudidaya::findOrFail($id);
        $riwayat->delete();

        return redirect()->route('riwayat-budidaya.index')->with('success', 'Riwayat budidaya berhasil dihapus!');
    }
}
