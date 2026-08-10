<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalSidang extends Model
{
    protected $table = 'jadwal_sidang';

    protected $guarded = [];

    public function perkara()
    {
        return $this->belongsTo(Perkara::class);
    }

    public function hakimKetua()
    {
        return $this->belongsTo(Hakim::class,'hakim_ketua_id');
    }

    public function hakimAnggota1()
    {
        return $this->belongsTo(Hakim::class,'hakim_anggota1_id');
    }

    public function hakimAnggota2()
    {
        return $this->belongsTo(Hakim::class,'hakim_anggota2_id');
    }

    public function panitera()
    {
        return $this->belongsTo(PaniteraPengganti::class,'panitera_pengganti_id');
    }

    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class);
    }
}
