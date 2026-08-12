<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaniteraPengganti extends Model
{
    protected $table = 'panitera_pengganti';

    protected $fillable = [
        'nama',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}