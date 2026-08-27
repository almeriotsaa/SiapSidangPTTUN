<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalSidang;
use App\Models\Kehadiran;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function index()
    {
        $jadwalList = JadwalSidang::with(['perkara', 'kehadiran.pihak'])
            ->orderBy('tanggal_sidang', 'desc')
            ->get();

        return view('kehadiran.kehadiran', compact('jadwalList'));
    }

    public function tandaiHadir(Kehadiran $kehadiran)
    {
        $kehadiran->update([
            'status' => 'Hadir',
            'waktu_kehadiran' => now(),
        ]);

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Kehadiran berhasil ditandai.');
    }
}