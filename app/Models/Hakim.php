<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hakim extends Model
{
    protected $table = 'hakim';

    protected $fillable = [
        'nama',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}