<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalSidang;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tanggal dari URL (?tanggal=2026-08-15), default hari ini kalau tidak ada / tidak valid
        $tanggalInput = $request->query('tanggal');
        try {
            $tanggal = $tanggalInput ? Carbon::parse($tanggalInput)->startOfDay() : today();
        } catch (\Exception $e) {
            $tanggal = today();
        }

        $jadwalPadaTanggal = JadwalSidang::withFullDetail()
            ->forTanggal($tanggal)
            ->orderBy('jam_sidang')
            ->get()
            // Jaga-jaga kalau ada jadwal_sidang yang perkara_id-nya sudah tidak
            // valid (data tidak konsisten) — jangan sampai bikin dashboard crash.
            ->filter(fn ($j) => $j->perkara !== null)
            ->values();

        $totalPerkara = $jadwalPadaTanggal->count();

        $totalSemuaHadir = $jadwalPadaTanggal->filter(
            fn ($j) => $j->statusRingkasan()['label'] === 'Semua Hadir'
        )->count();

        $totalKendala = $jadwalPadaTanggal->filter(
            fn ($j) => $j->statusRingkasan()['label'] === 'Ada Kendala Kehadiran'
        )->count();

        $totalBelumLengkap = $jadwalPadaTanggal->filter(
            fn ($j) => $j->statusRingkasan()['label'] === 'Belum Lengkap'
        )->count();

        return view('dashboard.dashboard', [
            'jadwalHariIni'      => $jadwalPadaTanggal,
            'tanggal'            => $tanggal,
            'totalPerkara'       => $totalPerkara,
            'totalSemuaHadir'    => $totalSemuaHadir,
            'totalKendala'       => $totalKendala,
            'totalBelumLengkap'  => $totalBelumLengkap,
        ]);
    }
}