<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JadwalSidang extends Model
{
    protected $table = 'jadwal_sidang';

    protected $fillable = [
        'perkara_id',
        'tanggal_sidang',
        'jam_sidang',
        'ruang_sidang',
        'hakim_ketua_id',
        'hakim_anggota1_id',
        'hakim_anggota2_id',
        'panitera_pengganti_id',
    ];

    protected $casts = [
        'tanggal_sidang' => 'date',
    ];

    public function perkara(): BelongsTo
    {
        return $this->belongsTo(Perkara::class, 'perkara_id');
    }

    public function hakimKetua(): BelongsTo
    {
        return $this->belongsTo(Hakim::class, 'hakim_ketua_id');
    }

    public function hakimAnggota1(): BelongsTo
    {
        return $this->belongsTo(Hakim::class, 'hakim_anggota1_id');
    }

    public function hakimAnggota2(): BelongsTo
    {
        return $this->belongsTo(Hakim::class, 'hakim_anggota2_id');
    }

    // Nama relasi 'panitera' (bukan 'paniteraPengganti') supaya cocok dengan
    // eager-load ->with(['panitera', ...]) yang sudah dipakai JadwalSidangController (guest).
    public function panitera(): BelongsTo
    {
        return $this->belongsTo(PaniteraPengganti::class, 'panitera_pengganti_id');
    }

    public function kehadiran(): HasMany
    {
        return $this->hasMany(Kehadiran::class, 'jadwal_sidang_id');
    }

    // Scope query: eager-load semua relasi yang dibutuhkan untuk menampilkan
    // detail jadwal sidang (dipakai bersama oleh Guest & Admin controller,
    // supaya query-nya konsisten tanpa perlu menggabung controller-nya).
    public function scopeWithFullDetail($query)
    {
        return $query->with([
            'perkara.pihak',
            'hakimKetua',
            'hakimAnggota1',
            'hakimAnggota2',
            'panitera',
            'kehadiran.pihak',
        ]);
    }

    // Scope query: filter berdasarkan tanggal sidang tertentu
    public function scopeForTanggal($query, $tanggal)
    {
        return $query->whereDate('tanggal_sidang', $tanggal);
    }

    // Batas waktu toleransi check-in: jam sidang + 15 menit
    public function batasWaktuHadir(): \Carbon\Carbon
    {
        return \Carbon\Carbon::parse($this->tanggal_sidang->format('Y-m-d') . ' ' . $this->jam_sidang)
            ->addMinutes(15);
    }

    public function sudahLewatBatas(): bool
    {
        return now()->greaterThan($this->batasWaktuHadir());
    }

    // Ringkasan status kehadiran keseluruhan untuk jadwal ini (dipakai di Dashboard).
    // Menggabungkan status semua pihak (Penggugat + Tergugat, bisa lebih dari satu masing-masing)
    // jadi satu label ringkas: 'Semua Hadir', 'Ada Kendala Kehadiran', atau 'Belum Lengkap'.
    public function statusRingkasan(): array
    {
        $statuses = $this->kehadiran->map(fn ($k) => $k->statusTampilan());

        if ($statuses->isEmpty()) {
            return ['label' => 'Belum Lengkap', 'badge' => 'bg-gray-100 text-gray-600 ring-1 ring-gray-200', 'dot' => 'bg-gray-400'];
        }

        if ($statuses->contains('Tidak Hadir')) {
            return ['label' => 'Ada Kendala Kehadiran', 'badge' => 'bg-red-50 text-red-600 ring-1 ring-red-200', 'dot' => 'bg-red-500'];
        }

        if ($statuses->every(fn ($s) => $s === 'Hadir')) {
            return ['label' => 'Semua Hadir', 'badge' => 'bg-green-50 text-green-700 ring-1 ring-green-200', 'dot' => 'bg-green-500'];
        }

        return ['label' => 'Belum Lengkap', 'badge' => 'bg-gray-100 text-gray-600 ring-1 ring-gray-200', 'dot' => 'bg-gray-400'];
    }
}