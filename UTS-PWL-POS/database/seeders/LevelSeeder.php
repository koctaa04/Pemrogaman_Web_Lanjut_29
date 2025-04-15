<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_level')->insert([
            [
                'level_kode'  => 'ADM',
                'level_nama'  => 'Admin',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'level_kode'  => 'KSR',
                'level_nama'  => 'Kasir',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
