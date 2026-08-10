<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerkaraSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('perkara')->insert([

            [
                'nomor_perkara'=>'17/G/2026/PT.TUN.JKT',
                'agenda'=>'Pemeriksaan Persiapan'
            ],

            [
                'nomor_perkara'=>'21/G/2026/PT.TUN.JKT',
                'agenda'=>'Pembuktian'
            ]

        ]);
    }
}