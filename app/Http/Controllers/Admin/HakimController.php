<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hakim;
use App\Models\PaniteraPengganti;
use Illuminate\Http\Request;

class HakimController extends Controller
{
    // Satu halaman menampilkan dua daftar: Majelis Hakim & Panitera Pengganti
    public function index()
    {
        $hakimList    = Hakim::orderBy('nama')->get();
        $paniteraList = PaniteraPengganti::orderBy('nama')->get();

        return view('hakim.hakim', compact('hakimList', 'paniteraList'));
    }

    // Simpan satu atau lebih nama hakim sekaligus
    public function store(Request $request)
    {
        $validated = $request->validate([
            'names'   => ['required', 'array', 'min:1'],
            'names.*' => ['required', 'string', 'max:255'],
        ]);

        foreach ($validated['names'] as $nama) {
            Hakim::create([
                'nama'  => $nama,
                'aktif' => true,
            ]);
        }

        return redirect()->route('hakim.index')->with('success', 'Data hakim berhasil ditambahkan.');
    }

    public function destroy(Hakim $hakim)
    {
        try {
            $hakim->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Hakim ini tidak bisa dihapus karena masih terpakai di jadwal sidang.');
        }

        return redirect()->route('hakim.index')->with('success', 'Data hakim berhasil dihapus.');
    }
}