<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuratController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute yang membutuhkan login (Validasi sesi ditangani di dalam controller)
Route::get('/dashboard', [SuratController::class, 'index'])->name('dashboard');
Route::get('/riwayat', [SuratController::class, 'riwayat'])->name('surat.riwayat');
Route::get('/surat/buat/{jenis}', [SuratController::class, 'create'])->name('surat.create');
Route::post('/surat/simpan', [SuratController::class, 'store'])->name('surat.store');
Route::get('/surat/{id}/cetak', [SuratController::class, 'cetakUlang'])->name('surat.cetak');
