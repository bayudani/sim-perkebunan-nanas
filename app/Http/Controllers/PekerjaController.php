<?php

namespace App\Http\Controllers;

use App\Models\Pekerja;
use Illuminate\Http\Request;

class PekerjaController extends Controller
{
    public function index()
    {
        $pekerjas = Pekerja::with('user')->orderBy('id_pekerja', 'asc')->get();

        return view('pekerja.index', compact('pekerjas'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses Ditolak. Hanya Admin yang dapat menambah data.');
        }

        return view('pekerja.form');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $request->validate([
            'id_pekerja' => 'required|string|max:30|unique:pekerjas,id_pekerja',
            'nama' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp' => 'required|string|max:20',
        ]);

        Pekerja::create([
            'id_pekerja' => $request->id_pekerja,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('pekerja.index')->with('success', 'Data pekerja berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $pekerja = Pekerja::findOrFail($id);
        return view('pekerja.form', compact('pekerja'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $pekerja = Pekerja::findOrFail($id);

        $request->validate([
            'id_pekerja' => 'required|string|max:30|unique:pekerjas,id_pekerja,'.$pekerja->id,
            'nama' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp' => 'required|string|max:20',
        ]);

        $pekerja->update([
            'id_pekerja' => $request->id_pekerja,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('pekerja.index')->with('success', 'Data pekerja berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $pekerja = Pekerja::findOrFail($id);
        $pekerja->delete();

        return redirect()->route('pekerja.index')->with('success', 'Data pekerja berhasil dihapus!');
    }
}
