<?php

namespace App\Http\Controllers;

use App\Models\SiswaModel;
use Illuminate\Http\Request;

class AdminSiswaController extends Controller
{
    //
    public function index()
    {        
        $siswa = SiswaModel::all();

        return view('admin.siswa.index', compact('siswa'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|unique:data_siswa,nisn',
            'nama' => 'required',
        ]);

        SiswaModel::create($request->all());
        return redirect()->route('admin.data-siswa')->with('success', 'Data siswa berhasil ditambahkan.');
    }
    
    public function update(Request $request, $id)
    {
        $siswa = SiswaModel::findOrFail($id);

        $request->validate([
            'nisn' => 'required|unique:data_siswa,nisn,' . $siswa->id,
            'nama' => 'required',
        ]);

        $siswa->update($request->all());

        return redirect()->route('admin.data-siswa')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = SiswaModel::findOrFail($id);
        $siswa->delete();

        return redirect()->route('admin.data-siswa')->with('success', 'Data siswa berhasil dihapus.');
    }
}
