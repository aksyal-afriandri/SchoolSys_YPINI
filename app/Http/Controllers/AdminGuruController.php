<?php

namespace App\Http\Controllers;

use App\Models\GuruModel;
use Illuminate\Http\Request;

class AdminGuruController extends Controller
{
    //
    public function index()
    {
        $guru = GuruModel::all();
        return view('admin.guru.index', compact('guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:data_guru,nip',
            'nama' => 'required',
        ]);

        GuruModel::create($request->all());

        return redirect()->route('admin.data-guru')->with('success', 'Data guru berhasil ditambahkan.');
    }
    public function update(Request $request, $id)
    {
        $guru = GuruModel::findOrFail($id);

        $request->validate([
            'nip' => 'required|unique:data_guru,nip,' . $guru->id,
            'nama' => 'required',
        ]);

        $guru->update($request->all());

        return redirect()->route('admin.data-guru')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $guru = GuruModel::findOrFail($id);
        $guru->delete();

        return redirect()->route('admin.data-guru')->with('success', 'Data guru berhasil dihapus.');
    }
}
