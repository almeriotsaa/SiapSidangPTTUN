<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function index()
    {
        // Satu baris per pihak (Penggugat/Tergugat), bukan per jadwal — supaya
        // perkara dengan banyak Penggugat/Tergugat tetap semuanya tertampil.
        $kehadiranList = Kehadiran::with(['jadwalSidang.perkara', 'pihak'])
            ->whereHas('jadwalSidang')
            ->get()
            ->sortBy([
                fn ($a, $b) => $a->jadwalSidang->tanggal_sidang <=> $b->jadwalSidang->tanggal_sidang,
                fn ($a, $b) => $a->jadwalSidang->jam_sidang <=> $b->jadwalSidang->jam_sidang,
            ])
            ->values();

        return view('kehadiran.kehadiran', compact('kehadiranList'));
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