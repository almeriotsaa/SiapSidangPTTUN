<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PihakPerkara extends Model
{
    protected $table='pihak_perkara';

    protected $guarded=[];

    public function perkara()
    {
        return $this->belongsTo(Perkara::class);
    }
}
