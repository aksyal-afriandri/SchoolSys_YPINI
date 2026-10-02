<?php

namespace App\Http\Controllers;


use App\Models\SiswaModel;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

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
        $validated = $request->validate([
            'nisn' => 'required|unique:data_siswa,nisn',
            'nama' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('siswa', 'public');
        }

        SiswaModel::create($validated);
        return redirect()->route('admin.data-siswa')->with('manual_success', 'Data siswa berhasil ditambahkan.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        $import = new SiswaImport();

        DB::transaction(function () use ($request, $import) {
            Excel::import($import, $request->file('file'));
        });

        if (! $import->foundHeaders) {
            throw ValidationException::withMessages([
                'file' => 'Tidak ditemukan sheet dengan header nisn dan nama pada baris ke-2.',
            ]);
        }

        if ($import->imported === 0 && $import->skipped === 0) {
            throw ValidationException::withMessages([
                'file' => 'Sheet dengan header siswa tidak berisi baris data.',
            ]);
        }

        return redirect()->route('admin.data-siswa')->with(
            'import_success',
            "Import selesai: {$import->imported} siswa ditambahkan, {$import->skipped} duplikat dilewati."
        );
    }
    
    public function update(Request $request, $id)
    {
        $siswa = SiswaModel::findOrFail($id);

        $validated = $request->validate([
            'nisn' => 'required|unique:data_siswa,nisn,' . $siswa->id,
            'nama' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $oldPhoto = $siswa->photo;
            $validated['photo'] = $request->file('photo')->store('siswa', 'public');
            $siswa->update($validated);

            if ($oldPhoto) {
                Storage::disk('public')->delete($oldPhoto);
            }
        } else {
            unset($validated['photo']);
            $siswa->update($validated);
        }

        return redirect()->route('admin.data-siswa')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = SiswaModel::findOrFail($id);
        $siswa->delete();

        return redirect()->route('admin.data-siswa')->with('success', 'Data siswa berhasil dihapus.');
    }
}
