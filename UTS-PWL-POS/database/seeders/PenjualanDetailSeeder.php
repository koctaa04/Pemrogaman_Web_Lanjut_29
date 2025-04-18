<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_penjualan_detail')->insert([
            [
                'penjualan_id'   => 1, 
                'barang_id'      => 1, 
                'jumlah'         => 2, 
                'harga'          => 19000000, 
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'penjualan_id'   => 2,
                'barang_id'      => 2,
                'jumlah'         => 1,
                'harga'          => 22000000,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'penjualan_id'   => 3,
                'barang_id'      => 3,
                'jumlah'         => 5,
                'harga'          => 18000,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'penjualan_id'   => 4, 
                'barang_id'      => 1, 
                'jumlah'         => 2, 
                'harga'          => 19000000, 
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'penjualan_id'   => 5,
                'barang_id'      => 2,
                'jumlah'         => 1,
                'harga'          => 22000000,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],

        ]);
    }
}
