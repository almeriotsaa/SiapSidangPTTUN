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

    public function pihakPerkara(): HasMany
    {
        return $this->hasMany(PihakPerkara::class, 'perkara_id');
    }

    public function penggugat(): HasMany
    {
        return $this->pihakPerkara()->where('tipe', 'penggugat');
    }

    public function tergugat(): HasMany
    {
        return $this->pihakPerkara()->where('tipe', 'tergugat');
    }

    public function jadwalSidang(): HasMany
    {
        return $this->hasMany(JadwalSidang::class, 'perkara_id');
    }
}