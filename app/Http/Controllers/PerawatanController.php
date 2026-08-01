<?php

namespace App\Http\Controllers;

use App\Models\Perawatan;
use App\Models\Pekerja;
use Illuminate\Http\Request;

class PerawatanController extends Controller
{
    public function index()
    {
        $perawatans = Perawatan::with(['user', 'pekerjas'])->orderBy('tanggal', 'desc')->get();

        return view('perawatan.index', compact('perawatans'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses Ditolak. Hanya Admin yang dapat menambah data.');
        }

        $pekerjas = Pekerja::orderBy('nama', 'asc')->get();

        return view('perawatan.form', compact('pekerjas'));
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

        $perawatan = Perawatan::create([
            'tanggal' => $request->tanggal,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'blok_lahan' => $request->blok_lahan,
            'keterangan' => $request->keterangan,
            'user_id' => auth()->id(),
        ]);

        if ($request->filled('pekerja_ids')) {
            $perawatan->pekerjas()->attach($request->pekerja_ids);
        }

        return redirect()->route('perawatan.index')->with('success', 'Data perawatan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $perawatan = Perawatan::with('pekerjas')->findOrFail($id);
        $pekerjas = Pekerja::orderBy('nama', 'asc')->get();

        return view('perawatan.form', compact('perawatan', 'pekerjas'));
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

        $perawatan = Perawatan::findOrFail($id);
        $perawatan->update([
            'tanggal' => $request->tanggal,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'blok_lahan' => $request->blok_lahan,
            'keterangan' => $request->keterangan,
        ]);

        $perawatan->pekerjas()->sync($request->pekerja_ids ?? []);

        return redirect()->route('perawatan.index')->with('success', 'Data perawatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $perawatan = Perawatan::findOrFail($id);
        $perawatan->delete();

        return redirect()->route('perawatan.index')->with('success', 'Data perawatan berhasil dihapus!');
    }
}
