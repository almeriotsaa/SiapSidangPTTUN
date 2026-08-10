<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PihakPerkaraSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pihak_perkara')->insert([

            [
                'perkara_id'=>1,
                'tipe'=>'penggugat',
                'nama'=>'Ir. Rully Chairul Azwar'
            ],
            [
                'perkara_id'=>1,
                'tipe'=>'penggugat',
                'nama'=>'PT Maju Bersama'
            ],
            [
                'perkara_id'=>1,
                'tipe'=>'tergugat',
                'nama'=>'Kepala Kantor Pertanahan Kabupaten Pandeglang'
            ],
            [
                'perkara_id'=>1,
                'tipe'=>'tergugat',
                'nama'=>'BPN Republik Indonesia'
            ],

            [
                'perkara_id'=>2,
                'type'=>'penggugat',
                'nama'=>'Ahmad Fauzi'
            ],
            [
                'perkara_id'=>2,
                'tipe'=>'tergugat',
                'nama'=>'Kementerian ATR/BPN'
            ]

        ]);
    }
}