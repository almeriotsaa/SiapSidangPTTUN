<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perkara;
use App\Models\PihakPerkara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerkaraController extends Controller
{
    public function index()
    {
        $perkaraList = Perkara::with('pihak')->orderByDesc('id')->get();

        return view('perkara.perkara', compact('perkaraList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_perkara'    => ['required', 'string', 'max:255', 'unique:perkara,nomor_perkara'],
            'agenda'           => ['required', 'string', 'max:255'],
            'penggugat'        => ['required', 'array', 'min:1'],
            'penggugat.*'      => ['required', 'string', 'max:255'],
            'tergugat'         => ['required', 'array', 'min:1'],
            'tergugat.*'       => ['required', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($validated) {
            $perkara = Perkara::create([
                'nomor_perkara' => $validated['nomor_perkara'],
                'agenda'        => $validated['agenda'],
            ]);

            foreach ($validated['penggugat'] as $nama) {
                PihakPerkara::create([
                    'perkara_id' => $perkara->id,
                    'tipe'       => 'penggugat',
                    'nama'       => $nama,
                ]);
            }

            foreach ($validated['tergugat'] as $nama) {
                PihakPerkara::create([
                    'perkara_id' => $perkara->id,
                    'tipe'       => 'tergugat',
                    'nama'       => $nama,
                ]);
            }
        });

        return redirect()->route('perkara.index')->with('success', 'Data perkara berhasil ditambahkan.');
    }

    public function update(Request $request, Perkara $perkara)
    {
        $validated = $request->validate([
            'nomor_perkara'    => ['required', 'string', 'max:255', 'unique:perkara,nomor_perkara,' . $perkara->id],
            'agenda'           => ['required', 'string', 'max:255'],
            'penggugat'        => ['required', 'array', 'min:1'],
            'penggugat.*'      => ['required', 'string', 'max:255'],
            'tergugat'         => ['required', 'array', 'min:1'],
            'tergugat.*'       => ['required', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($validated, $perkara) {
            $perkara->update([
                'nomor_perkara' => $validated['nomor_perkara'],
                'agenda'        => $validated['agenda'],
            ]);

            // Catatan: pihak lama dihapus & diganti daftar baru. Karena kehadiran
            // terhubung ke pihak_perkara dengan cascadeOnDelete, mengedit daftar
            // Penggugat/Tergugat pada perkara yang SUDAH punya riwayat kehadiran
            // akan ikut menghapus riwayat kehadiran terkait pihak yang dihapus.
            $perkara->pihak()->delete();

            foreach ($validated['penggugat'] as $nama) {
                PihakPerkara::create([
                    'perkara_id' => $perkara->id,
                    'tipe'       => 'penggugat',
                    'nama'       => $nama,
                ]);
            }

            foreach ($validated['tergugat'] as $nama) {
                PihakPerkara::create([
                    'perkara_id' => $perkara->id,
                    'tipe'       => 'tergugat',
                    'nama'       => $nama,
                ]);
            }
        });

        return redirect()->route('perkara.index')->with('success', 'Data perkara berhasil diperbarui.');
    }

    public function destroy(Perkara $perkara)
    {
        // Peringatan: menghapus perkara akan ikut menghapus semua jadwal sidang
        // dan riwayat kehadiran terkait (cascadeOnDelete pada skema database).
        $perkara->delete();

        return redirect()->route('perkara.index')->with('success', 'Data perkara berhasil dihapus.');
    }
}