<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PihakPerkara extends Model
{
    protected $table = 'pihak_perkara';

    protected $fillable = [
        'perkara_id',
        'tipe',
        'nama',
    ];

    public function perkara(): BelongsTo
    {
        return $this->belongsTo(Perkara::class, 'perkara_id');
    }
}