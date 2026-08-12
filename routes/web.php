<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\JadwalSidangController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\HakimController;
use App\Http\Controllers\Admin\PaniteraController;
use App\Http\Controllers\Admin\PerkaraController;
use App\Http\Controllers\Admin\JadwalSidangController as AdminJadwalSidangController;
use App\Http\Controllers\Admin\KehadiranController;
use App\Http\Controllers\Admin\RiwayatController;
use App\Http\Controllers\Admin\DashboardController;

// ============================
// Halaman publik (tidak perlu login)
// ============================
Route::get('/', function () {
    return view('guest.home');
});

Route::get('/jadwal', [JadwalSidangController::class, 'index']);

Route::get('/kontak', function () {
    return view('guest.kontak');
});

Route::get('/tentang', function () {
    return view('guest.tentang');
});

// ============================
// Autentikasi
// ============================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================
// Halaman admin (WAJIB login)
// ============================
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/kelola-jadwal', [AdminJadwalSidangController::class, 'index'])->name('kelola-jadwal.index');
    Route::post('/kelola-jadwal', [AdminJadwalSidangController::class, 'store'])->name('kelola-jadwal.store');
    Route::put('/kelola-jadwal/{jadwal}', [AdminJadwalSidangController::class, 'update'])->name('kelola-jadwal.update');
    Route::delete('/kelola-jadwal/{jadwal}', [AdminJadwalSidangController::class, 'destroy'])->name('kelola-jadwal.destroy');

    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

    Route::middleware('role:admin')->group(function () {

        Route::get('/perkara', [PerkaraController::class, 'index'])->name('perkara.index');
        Route::post('/perkara', [PerkaraController::class, 'store'])->name('perkara.store');
        Route::put('/perkara/{perkara}', [PerkaraController::class, 'update'])->name('perkara.update');
        Route::delete('/perkara/{perkara}', [PerkaraController::class, 'destroy'])->name('perkara.destroy');

        Route::get('/hakim', [HakimController::class, 'index'])->name('hakim.index');
        Route::post('/hakim', [HakimController::class, 'store'])->name('hakim.store');
        Route::delete('/hakim/{hakim}', [HakimController::class, 'destroy'])->name('hakim.destroy');

        Route::post('/panitera', [PaniteraController::class, 'store'])->name('panitera.store');
        Route::delete('/panitera/{panitera}', [PaniteraController::class, 'destroy'])->name('panitera.destroy');

    });

    Route::get('/kehadiran', [KehadiranController::class, 'index'])->name('kehadiran.index');
    Route::post('/kehadiran/{kehadiran}/tandai-hadir', [KehadiranController::class, 'tandaiHadir'])->name('kehadiran.tandai-hadir');

});