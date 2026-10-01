<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaranModel;
use Illuminate\Http\Request;

class AdminTahunController extends Controller
{
    //
    public function index()
    {
        $tahunAjaran = TahunAjaranModel::all();
        return view('admin.tahun.index', compact('tahunAjaran'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|unique:tahun_ajaran,tahun_ajaran',
        ]);

        TahunAjaranModel::create($request->all());

        return redirect()->route('admin.data-tahun')->with('success', 'Data tahun ajaran berhasil ditambahkan.');
    }
    public function update(Request $request, $id){
        $request->validate([
            'tahun_ajaran' => 'required|unique:tahun_ajaran,tahun_ajaran,' . $id,
        ]);

        $tahunAjaran = TahunAjaranModel::findOrFail($id);
        $tahunAjaran->update($request->all());

        return redirect()->route('admin.data-tahun')->with('success', 'Data tahun ajaran berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $tahunAjaran = TahunAjaranModel::findOrFail($id);
        $tahunAjaran->delete();

        return redirect()->route('admin.data-tahun')->with('success', 'Data tahun ajaran berhasil dihapus.');
    }
}
