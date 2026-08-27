<?php

namespace App\Http\Controllers\Admin;

use App\Events\JadwalSidangUpdated;
use App\Http\Controllers\Controller;
use App\Models\Hakim;
use App\Models\JadwalSidang;
use App\Models\Kehadiran;
use App\Models\PaniteraPengganti;
use App\Models\Perkara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalSidangController extends Controller
{
    public function index()
    {
        $jadwalList = JadwalSidang::withFullDetail()->orderByDesc('tanggal_sidang')->orderBy('jam_sidang')->get();

        $perkaraList  = Perkara::with('pihak')->orderBy('nomor_perkara')->get();
        $hakimList    = Hakim::orderBy('nama')->get();
        $paniteraList = PaniteraPengganti::orderBy('nama')->get();

        return view('jadwal.kelola', compact('jadwalList', 'perkaraList', 'hakimList', 'paniteraList'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateJadwal($request);

        DB::transaction(function () use ($validated) {
            $jadwal = JadwalSidang::create($validated);
            $this->buatKehadiranUntukPerkara($jadwal);
        });

        broadcast(new JadwalSidangUpdated())->toOthers();

        return redirect()->route('kelola-jadwal.index')->with('success', 'Jadwal sidang berhasil ditambahkan.');
    }

    public function update(Request $request, JadwalSidang $jadwal)
    {
        $validated = $this->validateJadwal($request);

        DB::transaction(function () use ($validated, $jadwal) {
            $perkaraBerubah = $jadwal->perkara_id !== (int) $validated['perkara_id'];

            $jadwal->update($validated);

            if ($perkaraBerubah) {
                $jadwal->kehadiran()->delete();
                $this->buatKehadiranUntukPerkara($jadwal);
            }
        });

        broadcast(new JadwalSidangUpdated())->toOthers();

        return redirect()->route('kelola-jadwal.index')->with('success', 'Jadwal sidang berhasil diperbarui.');
    }

    public function destroy(JadwalSidang $jadwal)
    {
        $jadwal->delete();

        broadcast(new JadwalSidangUpdated())->toOthers();

        return redirect()->route('kelola-jadwal.index')->with('success', 'Jadwal sidang berhasil dihapus.');
    }

    private function validateJadwal(Request $request): array
    {
        return $request->validate([
            'perkara_id'             => ['required', 'exists:perkara,id'],
            'tanggal_sidang'         => ['required', 'date'],
            'jam_sidang'             => ['required'],
            'ruang_sidang'           => ['required', 'string', 'max:255'],
            'hakim_ketua_id'         => ['required', 'exists:hakim,id'],
            'hakim_anggota1_id'      => ['required', 'exists:hakim,id', 'different:hakim_ketua_id'],
            'hakim_anggota2_id'      => ['required', 'exists:hakim,id', 'different:hakim_ketua_id', 'different:hakim_anggota1_id'],
            'panitera_pengganti_id'  => ['required', 'exists:panitera_pengganti,id'],
        ]);
    }

    private function buatKehadiranUntukPerkara(JadwalSidang $jadwal): void
    {
        $perkara = Perkara::with('pihak')->find($jadwal->perkara_id);

        foreach ($perkara->pihakPerkara as $pihakPerkara) {
            Kehadiran::create([
                'jadwal_sidang_id' => $jadwal->id,
                'pihak_perkara_id' => $pihakPerkara->id,
                'status'           => 'Belum Hadir',
            ]);
        }
    }
}