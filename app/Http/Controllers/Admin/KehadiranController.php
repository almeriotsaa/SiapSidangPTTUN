<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalSidang;
use App\Models\Kehadiran;

class KehadiranController extends Controller
{
    public function index()
    {
        // Satu baris per jadwal sidang. Kalau ada beberapa Penggugat/Tergugat,
        // semuanya ditumpuk di dalam kolom Penggugat/Tergugat yang sama —
        // bukan bikin kolom atau baris baru.
        $jadwalList = JadwalSidang::withFullDetail()
            ->orderBy('tanggal_sidang')
            ->orderBy('jam_sidang')
            ->get()
            ->filter(fn ($j) => $j->perkara !== null)
            ->values();

        return view('kehadiran.kehadiran', compact('jadwalList'));
    }

    // Hanya bisa dipanggil oleh Front Office — Admin ditolak di server,
    // bukan cuma disembunyikan tombolnya di tampilan.
    public function tandaiHadir(Kehadiran $kehadiran)
    {
        if (auth()->user()->role === 'admin') {
            abort(403, 'Admin tidak memiliki akses untuk menandai kehadiran.');
        }

        if ($kehadiran->status === 'Hadir') {
            return back()->with('error', 'Data ini sudah ditandai hadir sebelumnya.');
        }

        if ($kehadiran->jadwalSidang->sudahLewatBatas()) {
            return back()->with('error', 'Waktu toleransi kehadiran untuk jadwal ini sudah lewat.');
        }

        $kehadiran->update([
            'status'      => 'Hadir',
            'waktu_hadir' => now(),
        ]);

        return back()->with('success', 'Kehadiran berhasil ditandai.');
    }
}