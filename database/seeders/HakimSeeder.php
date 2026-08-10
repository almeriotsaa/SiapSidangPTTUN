<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HakimSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('hakim')->insert([

            ['nama'=>'Dr. Ulia Alba, S.H., M.H.','aktif'=>1],
            ['nama'=>'Listyorani Imawati, S.H., M.H.','aktif'=>1],
            ['nama'=>'Berdyan Shonata, S.H.','aktif'=>1],
            ['nama'=>'Andi Prasetyo, S.H., M.H.','aktif'=>1],
            ['nama'=>'Gunuh Hadi, S.H.','aktif'=>1],

        ]);
    }
}