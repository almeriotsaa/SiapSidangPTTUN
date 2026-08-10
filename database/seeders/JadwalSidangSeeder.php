<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSidangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jadwal_sidang')->insert([

            [
                'perkara_id'=>1,
                'tanggal_sidang'=>'2026-08-10',
                'jam_sidang'=>'09:00:00',
                'ruang_sidang'=>'Ruang Sidang I',

                'hakim_ketua_id'=>1,
                'hakim_anggota1_id'=>2,
                'hakim_anggota2_id'=>3,

                'panitera_pengganti_id'=>1
            ],

            [
                'perkara_id'=>2,
                'tanggal_sidang'=>'2026-08-10',
                'jam_sidang'=>'11:00:00',
                'ruang_sidang'=>'Ruang Sidang II',

                'hakim_ketua_id'=>4,
                'hakim_anggota1_id'=>5,
                'hakim_anggota2_id'=>2,

                'panitera_pengganti_id'=>2
            ]

        ]);
    }
}