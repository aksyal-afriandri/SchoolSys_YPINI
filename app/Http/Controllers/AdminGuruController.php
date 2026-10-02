<?php

namespace App\Http\Controllers;

use App\Models\GuruModel;
use App\Imports\GuruImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        $import = new GuruImport();

        DB::transaction(function () use ($request, $import) {
            Excel::import($import, $request->file('file'));
        });

        if (! $import->foundHeaders) {
            throw ValidationException::withMessages([
                'file' => 'Tidak ditemukan sheet dengan header nip dan nama pada baris ke-2.',
            ]);
        }

        if ($import->imported === 0 && $import->skipped === 0) {
            throw ValidationException::withMessages([
                'file' => 'Sheet dengan header guru tidak berisi baris data.',
            ]);
        }

        return redirect()->route('admin.data-guru')->with(
            'import_success',
            "Import selesai: {$import->imported} guru ditambahkan, {$import->skipped} duplikat dilewati."
        );
    }
}
