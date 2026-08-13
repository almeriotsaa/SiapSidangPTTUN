<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Perkara extends Model
{
    protected $table = 'perkara';

    protected $fillable = [
        'nomor_perkara',
        'agenda',
    ];

    // Relasi utama — dipakai di semua halaman admin (Dashboard, Kelola Jadwal,
    // Kehadiran, Perkara).
    public function pihak(): HasMany
    {
        return $this->hasMany(PihakPerkara::class, 'perkara_id');
    }

    // Alias — dipakai oleh view guest.jadwal (dibuat sebelum model ini ada).
    // JANGAN hapus salah satu dari dua method ini; keduanya harus tetap ada
    // supaya kedua sisi (admin & guest) sama-sama jalan.
    public function pihakPerkara(): HasMany
    {
        return $this->pihak();
    }

    public function penggugat(): HasMany
    {
        return $this->pihak()->where('tipe', 'penggugat');
    }

    public function tergugat(): HasMany
    {
        return $this->pihak()->where('tipe', 'tergugat');
    }

    public function jadwalSidang(): HasMany
    {
        return $this->hasMany(JadwalSidang::class, 'perkara_id');
    }
}