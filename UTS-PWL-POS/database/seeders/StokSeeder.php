<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_stok')->insert([
            [
                'barang_id'      => 1, 
                'user_id'        => 1, 
                'supplier_id'    => 1,
                'stok_tanggal'   => now(), 
                'stok_jumlah'    => 50, 
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'barang_id'      => 2,
                'user_id'        => 1, 
                'supplier_id'    => 2,
                'stok_tanggal'   => now(),
                'stok_jumlah'    => 30,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'barang_id'      => 3,
                'user_id'        => 1, 
                'supplier_id'    => 2,
                'stok_tanggal'   => now(),
                'stok_jumlah'    => 100,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
