<?php

namespace App\Http\Controllers;

use App\Models\PelajaranModel;
use Illuminate\Http\Request;

class AdminPelajaranController extends Controller
{
    //
    public function index()
    {
        $pelajaran = PelajaranModel::all();
        return view('admin.pelajaran.index', compact('pelajaran'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelajaran' => 'required|unique:data_pelajaran,nama_pelajaran',
        ]);

        PelajaranModel::create($request->all());

        return redirect()->route('admin.data-pelajaran')->with('success', 'Data pelajaran berhasil ditambahkan.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelajaran' => 'required|unique:data_pelajaran,nama_pelajaran,' . $id,
        ]);

        $pelajaran = PelajaranModel::findOrFail($id);
        $pelajaran->update($request->all());

        return redirect()->route('admin.data-pelajaran')->with('success', 'Data pelajaran berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $pelajaran = PelajaranModel::findOrFail($id);
        $pelajaran->delete();

        return redirect()->route('admin.data-pelajaran')->with('success', 'Data pelajaran berhasil dihapus.');
    }
}
