<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaniteraPengganti;
use Illuminate\Http\Request;

class PaniteraController extends Controller
{
    // Tidak ada halaman index sendiri — Panitera Pengganti ditampilkan
    // bersama Majelis Hakim di satu halaman yang sama (lihat HakimController@index)

    public function store(Request $request)
    {
        $validated = $request->validate([
            'names'   => ['required', 'array', 'min:1'],
            'names.*' => ['required', 'string', 'max:255'],
        ]);

        foreach ($validated['names'] as $nama) {
            PaniteraPengganti::create([
                'nama'  => $nama,
                'aktif' => true,
            ]);
        }

        return redirect()->route('hakim.index')->with('success', 'Data panitera pengganti berhasil ditambahkan.');
    }

    public function destroy(PaniteraPengganti $panitera)
    {
        try {
            $panitera->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Panitera ini tidak bisa dihapus karena masih terpakai di jadwal sidang.');
        }

        return redirect()->route('hakim.index')->with('success', 'Data panitera pengganti berhasil dihapus.');
    }
}