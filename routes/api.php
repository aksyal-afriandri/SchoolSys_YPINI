<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiDataController;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'app' => config('app.name'),
        'time' => now()->toIso8601String(),
    ]);
});

Route::post('/login', [ApiAuthController::class, 'login'])->middleware('throttle:5,1');

Route::middleware('api.token')->group(function () {
    Route::get('/user', [ApiAuthController::class, 'user']);
    Route::post('/logout', [ApiAuthController::class, 'logout']);

    Route::get('/data/siswa/{id}/photo', [ApiDataController::class, 'photo'])->whereNumber('id');
    Route::get('/data/{resource}', [ApiDataController::class, 'index'])
        ->whereIn('resource', ['siswa', 'guru', 'kelas', 'pelajaran', 'tahun']);
    Route::post('/data/{resource}', [ApiDataController::class, 'store'])
        ->whereIn('resource', ['siswa', 'guru', 'kelas', 'pelajaran', 'tahun']);
    Route::get('/data/{resource}/{id}', [ApiDataController::class, 'show'])
        ->whereIn('resource', ['siswa', 'guru', 'kelas', 'pelajaran', 'tahun']);
    Route::put('/data/{resource}/{id}', [ApiDataController::class, 'update'])
        ->whereIn('resource', ['siswa', 'guru', 'kelas', 'pelajaran', 'tahun']);
    Route::patch('/data/{resource}/{id}', [ApiDataController::class, 'update'])
        ->whereIn('resource', ['siswa', 'guru', 'kelas', 'pelajaran', 'tahun']);
    Route::delete('/data/{resource}/{id}', [ApiDataController::class, 'destroy'])
        ->whereIn('resource', ['siswa', 'guru', 'kelas', 'pelajaran', 'tahun']);
});
