<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_penjualan')->insert([
            [
                'user_id'           => 1, // Merujuk ke user dengan id 1
                'pembeli'           => 'Budi Santoso',
                'penjualan_kode'    => 'PNJ01',
                'penjualan_tanggal' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'user_id'           => 2, // Merujuk ke user dengan id 2
                'pembeli'           => 'Siti Aminah',
                'penjualan_kode'    => 'PNJ02',
                'penjualan_tanggal' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'user_id'           => 2, // Merujuk ke user dengan id 2
                'pembeli'           => 'Agus Salim',
                'penjualan_kode'    => 'PNJ03',
                'penjualan_tanggal' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'user_id'           => 1, // Merujuk ke user dengan id 1
                'pembeli'           => 'Dewi Lestari',
                'penjualan_kode'    => 'PNJ04',
                'penjualan_tanggal' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'user_id'           => 2, // Merujuk ke user dengan id 2
                'pembeli'           => 'Ahmad Fauzi',
                'penjualan_kode'    => 'PNJ05',
                'penjualan_tanggal' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ]);
    }
}
