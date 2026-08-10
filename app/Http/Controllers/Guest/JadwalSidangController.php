<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\JadwalSidang;
use Illuminate\Http\Request;

class JadwalSidangController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->toDateString());

        $jadwal = JadwalSidang::with([
            'perkara.pihakPerkara',
            'hakimKetua',
            'hakimAnggota1',
            'hakimAnggota2',
            'panitera',
            'kehadiran.pihak'
        ])
            ->whereDate('tanggal_sidang', $tanggal)
            ->orderBy('jam_sidang')
            ->get();

        return view('guest.jadwal', compact('jadwal', 'tanggal'));
    }
}
