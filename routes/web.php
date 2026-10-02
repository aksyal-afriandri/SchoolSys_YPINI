<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

// Admin Controller
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminKelasController;
use App\Http\Controllers\AdminGuruController;
use App\Http\Controllers\AdminPelajaranController;
use App\Http\Controllers\AdminTahunController;
use App\Http\Controllers\AdminSiswaController;

//Login Route
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');

// middleware role
Route::middleware('auth')->group(function () {
    Route::get('/admin/index', [AdminDashboardController::class, 'index'])->name('admin.index');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Admin Route
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

// Admin DataSiswa 
Route::get('/admin/siswa/data-siswa', [AdminSiswaController::class, 'index'])->name('admin.data-siswa');
Route::post('/admin/siswa/data-siswa/import', [AdminSiswaController::class, 'import'])->name('admin.data-siswa.import');
Route::post('/admin/siswa/data-siswa', [AdminSiswaController::class, 'store'])->name('admin.data-siswa.store');
Route::put('/admin/siswa/data-siswa/{id}', [AdminSiswaController::class, 'update'])->name('admin.data-siswa.update');
Route::delete('/admin/siswa/data-siswa/{id}', [AdminSiswaController::class, 'destroy'])->name('admin.data-siswa.destroy');

//Admin DataGuru
Route::get('/admin/guru/data-guru', [AdminGuruController::class, 'index'])->name('admin.data-guru');
Route::post('/admin/guru/data-guru', [AdminGuruController::class, 'store'])->name('admin.data-guru.store');
Route::post('/admin/guru/data-guru/import', [AdminGuruController::class, 'import'])->name('admin.data-guru.import');
Route::put('/admin/guru/data-guru/{id}', [AdminGuruController::class, 'update'])->name('admin.data-guru.update');
Route::delete('/admin/guru/data-guru/{id}', [AdminGuruController::class, 'destroy'])->name('admin.data-guru.destroy');

//Admin DatKelas
Route::get('/admin/kelas/data-kelas', [AdminKelasController::class, 'index'])->name('admin.data-kelas');
Route::post('/admin/kelas/data-kelas', [AdminKelasController::class, 'store'])->name('admin.data-kelas.store');
Route::put('/admin/kelas/data-kelas/{id}', [AdminKelasController::class, 'update'])->name('admin.data-kelas.update');
Route::delete('/admin/kelas/data-kelas/{id}', [AdminKelasController::class, 'destroy'])->name('admin.data-kelas.destroy');

//Admin DatPel
Route::get('/admin/pelajaran/data-pelajaran', [AdminPelajaranController::class, 'index'])->name('admin.data-pelajaran');
Route::post('/admin/pelajaran/data-pelajaran', [AdminPelajaranController::class, 'store'])->name('admin.data-pelajaran.store');
Route::put('/admin/pelajaran/data-pelajaran/{id}', [AdminPelajaranController::class, 'update'])->name('admin.data-pelajaran.update');
Route::delete('/admin/pelajaran/data-pelajaran/{id}', [AdminPelajaranController::class, 'destroy'])->name('admin.data-pelajaran.destroy');

// admin dattahun
Route::get('/admin/tahun/data-tahun', [AdminTahunController::class, 'index'])->name('admin.data-tahun');
Route::post('/admin/tahun/data-tahun', [AdminTahunController::class, 'store'])->name('admin.data-tahun.store');
Route::put('/admin/tahun/data-tahun/{id}', [AdminTahunController::class, 'update'])->name('admin.data-tahun.update');
Route::delete('/admin/tahun/data-tahun/{id}', [AdminTahunController::class, 'destroy'])->name('admin.data-tahun.destroy');

//Guru Route
//Siswa Route