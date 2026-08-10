<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaniteraPenggantiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('panitera_pengganti')->insert([

            ['nama'=>'Hambali, S.H., M.H.','aktif'=>1],
            ['nama'=>'Rahmat Hidayat, S.H.','aktif'=>1],
            ['nama'=>'Rizky Ananda, S.H.','aktif'=>1],

        ]);
    }
}