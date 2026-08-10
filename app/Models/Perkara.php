<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perkara extends Model
{
    protected $table = 'perkara';

    protected $guarded = [];

    public function pihakPerkara()
    {
        return $this->hasMany(PihakPerkara::class);
    }

    public function jadwalSidang()
    {
        return $this->hasOne(JadwalSidang::class);
    }
}
