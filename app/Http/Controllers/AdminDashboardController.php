<?php

namespace App\Http\Controllers;

use App\Models\KelasModel;
use App\Models\SiswaModel;
use App\Models\GuruModel;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    //
    public function index()
    {
        $siswaCount = SiswaModel::count();
        $guruCount = GuruModel::count();
        $kelasCount = KelasModel::count();
        return view('admin.index', compact('siswaCount', 'guruCount', 'kelasCount'));
    }
}
