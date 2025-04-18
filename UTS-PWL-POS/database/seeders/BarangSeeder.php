<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_barang')->insert([
            [
                'kategori_id'   => 1,
                'barang_kode'   => 'ELT-001',
                'barang_nama'   => 'iPhone 14 Pro Max',
                'stok'          => 100,
                'harga_beli'    => 17000000,
                'harga_jual'    => 19000000,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'kategori_id'   => 1,
                'barang_kode'   => 'ELT-002',
                'barang_nama'   => 'Asus ROG Strix G15',
                'stok'          => 100,
                'harga_beli'    => 20000000,
                'harga_jual'    => 22000000,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'kategori_id'   => 2,
                'barang_kode'   => 'PKA-001',
                'barang_nama'   => 'Premium Hoodie Black',
                'stok'          => 100,
                'harga_beli'    => 100000,
                'harga_jual'    => 150000,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'kategori_id'   => 2,
                'barang_kode'   => 'PKA-002',
                'barang_nama'   => 'EIGER Hiking Backpack',
                'stok'          => 100,
                'harga_beli'    => 350000,
                'harga_jual'    => 400000,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'kategori_id'   => 3,
                'barang_kode'   => 'CML-001',
                'barang_nama'   => 'Crispy Chocolate Bar',
                'stok'          => 100,
                'harga_beli'    => 12000,
                'harga_jual'    => 18000,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'kategori_id'   => 3,
                'barang_kode'   => 'CML-002',
                'barang_nama'   => 'Nahati Chocolate Mix',
                'stok'          => 100,
                'harga_beli'    => 8000,
                'harga_jual'    => 12000,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'kategori_id'   => 4,
                'barang_kode'   => 'BKU-001',
                'barang_nama'   => 'The Power of Habit',
                'stok'          => 100,
                'harga_beli'    => 75000,
                'harga_jual'    => 95000,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'kategori_id'   => 4,
                'barang_kode'   => 'BKU-002',
                'barang_nama'   => 'Atomic Habits Revised Edition',
                'stok'          => 100,
                'harga_beli'    => 55000,
                'harga_jual'    => 70000,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'kategori_id'   => 5,
                'barang_kode'   => 'SPT-001',
                'barang_nama'   => 'Nike Air Jordan 1',
                'stok'          => 100,
                'harga_beli'    => 250000,
                'harga_jual'    => 300000,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'kategori_id'   => 5,
                'barang_kode'   => 'SPT-002',
                'barang_nama'   => 'Adidas Yeezy Boost 350',
                'stok'          => 100,
                'harga_beli'    => 1200000,
                'harga_jual'    => 1400000,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}
