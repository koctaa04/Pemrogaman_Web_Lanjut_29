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
                'user_id'           => 2, // Merujuk ke user dengan id 3
                'pembeli'           => 'Siti Aminah',
                'penjualan_kode'    => 'PNJ02',
                'penjualan_tanggal' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'user_id'           => 2, // Merujuk ke user dengan id 3
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
                'user_id'           => 2, // Merujuk ke user dengan id 3
                'pembeli'           => 'Ahmad Fauzi',
                'penjualan_kode'    => 'PNJ05',
                'penjualan_tanggal' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'user_id'           => 1, // Merujuk ke user dengan id 1
                'pembeli'           => 'Rina Suryani',
                'penjualan_kode'    => 'PNJ06',
                'penjualan_tanggal' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'user_id'           => 2, // Merujuk ke user dengan id 3
                'pembeli'           => 'Joko Susilo',
                'penjualan_kode'    => 'PNJ07',
                'penjualan_tanggal' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'user_id'           => 2, // Merujuk ke user dengan id 2
                'pembeli'           => 'Lilis Kurniawati',
                'penjualan_kode'    => 'PNJ08',
                'penjualan_tanggal' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'user_id'           => 2, // Merujuk ke user dengan id 3
                'pembeli'           => 'Hendra Wijaya',
                'penjualan_kode'    => 'PNJ09',
                'penjualan_tanggal' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'user_id'           => 2, // Merujuk ke user dengan id 2
                'pembeli'           => 'Tuti Pertiwi',
                'penjualan_kode'    => 'PNJ10',
                'penjualan_tanggal' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ]);
    }
}
