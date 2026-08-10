<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KehadiranSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kehadiran')->insert([

            [
                'jadwal_sidang_id'=>1,
                'pihak_perkara_id'=>1,
                'status'=>'Hadir',
                'waktu_hadir'=>'2026-08-10 08:41:12'
            ],

            [
                'jadwal_sidang_id'=>1,
                'pihak_perkara_id'=>2,
                'status'=>'Belum Hadir',
                'waktu_hadir'=>NULL
            ],

            [
                'jadwal_sidang_id'=>1,
                'pihak_perkara_id'=>3,
                'status'=>'Belum Hadir',
                'waktu_hadir'=>NULL
            ],

            [
                'jadwal_sidang_id'=>1,
                'pihak_perkara_id'=>4,
                'status'=>'Belum Hadir',
                'waktu_hadir'=>NULL
            ],

            [
                'jadwal_sidang_id'=>2,
                'pihak_perkara_id'=>5,
                'status'=>'Belum Hadir',
                'waktu_hadir'=>NULL
            ],

            [
                'jadwal_sidang_id'=>2,
                'pihak_perkara_id'=>6,
                'status'=>'Belum Hadir',
                'waktu_hadir'=>NULL
            ]

        ]);
    }
}