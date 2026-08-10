<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nama' => 'Administrator',
                'email' => 'admin@siapsidang.id',
                'password' => Hash::make('siapsidang'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Front Office',
                'email' => 'fo@siapsidang.id',
                'password' => Hash::make('siapsidang'),
                'role' => 'front_office',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}