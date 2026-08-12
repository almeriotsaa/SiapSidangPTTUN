<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kehadiran extends Model
{
    protected $table = 'kehadiran';

    protected $fillable = [
        'jadwal_sidang_id',
        'pihak_perkara_id',
        'status',
        'waktu_hadir',
    ];

    protected $casts = [
        'waktu_hadir' => 'datetime',
    ];

    public function jadwalSidang(): BelongsTo
    {
        return $this->belongsTo(JadwalSidang::class, 'jadwal_sidang_id');
    }

    // Nama relasi 'pihak' (bukan 'pihakPerkara') supaya cocok dengan
    // eager-load ->with(['kehadiran.pihak']) yang sudah dipakai JadwalSidangController (guest).
    public function pihak(): BelongsTo
    {
        return $this->belongsTo(PihakPerkara::class, 'pihak_perkara_id');
    }

    public function statusTampilan(): string
    {
        if ($this->status === 'Hadir') {
            return 'Hadir';
        }

        if ($this->jadwalSidang && $this->jadwalSidang->sudahLewatBatas()) {
            return 'Tidak Hadir';
        }

        return 'Belum Hadir';
    }

    
    public function bisaDitandaiHadir(): bool
    {
        return $this->status !== 'Hadir'
            && $this->jadwalSidang
            && !$this->jadwalSidang->sudahLewatBatas();
    }
}