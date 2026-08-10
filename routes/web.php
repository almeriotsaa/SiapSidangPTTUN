<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\JadwalSidangController;

Route::get('/', function () {
    return view('guest.home');
});

Route::get('/jadwal',[JadwalSidangController::class,'index']);

Route::get('/kontak', function () {
    return view('guest.kontak');
});

Route::get('/tentang', function () {
    return view('guest.tentang');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
});

Route::get('/kelola-jadwal', function () {
    $perkaraList = [
        ['perkara' => '123/Pdt.G/2026/PN.Jkt.Ps', 'agenda' => 'Pembuktian Penggugat', 'penggugat' => 'Tajudin, DKK', 'tergugat' => 'Kepala Kantor Pertanahan Kabupaten Pandeglang'],
        ['perkara' => '45/Pid.B/2026/PN.Jkt.Ps', 'agenda' => 'Pemeriksaan Saksi', 'penggugat' => 'JPU Kejari Jakarta Pusat', 'tergugat' => 'Ahmad Fauzi (Terdakwa)'],
        ['perkara' => '78/Pdt.G/2026/PN.Jkt.Ps', 'agenda' => 'Mediasi', 'penggugat' => 'Ny. Ratna Wijaya', 'tergugat' => 'CV Karya Abadi'],
    ];

    $hakimList = [
        'Dr. H. Ahmad Sutrisno, S.H., M.H.',
        'Hj. Rina Marlina, S.H., M.H.',
        'Bambang Setiawan, S.H., M.H.',
        'Drs. H. Slamet Riyadi, S.H., M.H.',
        'Yuni Kartika, S.H., M.H.',
        'Agus Salim, S.H., M.H.',
    ];

    $paniteraList = [
        'Siti Aminah, S.H.',
        'Rudi Hartono, S.H.',
        'Dewi Lestari, S.H.',
    ];

    return view('jadwal.kelola', compact('perkaraList', 'hakimList', 'paniteraList'));
});

Route::get('/riwayat', function () {
    return view('jadwal.riwayat');
});

Route::get('/perkara', function () {
    return view('perkara.perkara');
});

Route::post('/logout', function () {
    return redirect('/');
})->name('logout');

Route::get('/hakim', function () {
    return view('hakim.hakim');
});

Route::get('/kehadiran', function () {
    return view('kehadiran.kehadiran');
});