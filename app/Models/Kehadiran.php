<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    protected $table='kehadiran';

    protected $guarded=[];

    public function pihak()
    {
        return $this->belongsTo(PihakPerkara::class,'pihak_perkara_id');
    }
}
