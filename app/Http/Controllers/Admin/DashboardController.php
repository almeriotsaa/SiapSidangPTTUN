<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalSidang;

class DashboardController extends Controller
{
    public function index()
    {
        $jadwalHariIni = JadwalSidang::withFullDetail()
            ->forTanggal(today())
            ->orderBy('jam_sidang')
            ->get();

        $totalPerkara = $jadwalHariIni->count();

        $totalSemuaHadir = $jadwalHariIni->filter(
            fn ($j) => $j->statusRingkasan()['label'] === 'Semua Hadir'
        )->count();

        $totalKendala = $jadwalHariIni->filter(
            fn ($j) => $j->statusRingkasan()['label'] === 'Ada Kendala Kehadiran'
        )->count();

        $totalBelumLengkap = $jadwalHariIni->filter(
            fn ($j) => $j->statusRingkasan()['label'] === 'Belum Lengkap'
        )->count();

        return view('dashboard.dashboard', compact(
            'jadwalHariIni',
            'totalPerkara',
            'totalSemuaHadir',
            'totalKendala',
            'totalBelumLengkap'
        ));
    }
}