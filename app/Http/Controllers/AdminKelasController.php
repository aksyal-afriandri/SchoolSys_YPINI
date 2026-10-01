<?php

namespace App\Http\Controllers;

use App\Models\KelasModel;
use Illuminate\Http\Request;

class AdminKelasController extends Controller
{
    //
    public function index()
    {
        $kelas = KelasModel::all();
        return view('admin.kelas.index', compact('kelas'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|unique:data_kelas,nama_kelas',
        ]);

        KelasModel::create($request->all());

        return redirect()->route('admin.data-kelas')->with('success', 'Data kelas berhasil ditambahkan.');
    }
    public function update(Request $request, $id)
    {
        $kelas = KelasModel::findOrFail($id);

        $request->validate([
            'nama_kelas' => 'required|unique:data_kelas,nama_kelas,' . $kelas->id,
        ]);

        $kelas->update($request->all());

        return redirect()->route('admin.data-kelas')->with('success', 'Data kelas berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $kelas = KelasModel::findOrFail($id);
        $kelas->delete();

        return redirect()->route('admin.data-kelas')->with('success', 'Data kelas berhasil dihapus.');
    }
}
