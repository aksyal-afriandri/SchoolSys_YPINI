<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');

Route::middleware('auth')->group(function () {
    Route::get('/admin/index', function () {
        return view('admin/index');
    })->name('admin.index');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});


