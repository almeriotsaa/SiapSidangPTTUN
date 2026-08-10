<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([

            UserSeeder::class,
            HakimSeeder::class,
            PaniteraPenggantiSeeder::class,
            PerkaraSeeder::class,
            PihakPerkaraSeeder::class,
            JadwalSidangSeeder::class,
            KehadiranSeeder::class,

        ]);
    }
}