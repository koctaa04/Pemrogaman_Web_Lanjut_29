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
        $data = [
            ['barang_id' => 1, 'kategori_id' => 1, 'barang_kode' => 'TV001', 'barang_nama' => 'Televisi', 'harga_beli' => 2000000, 'harga_jual' => 2500000],
            ['barang_id' => 2, 'kategori_id' => 1, 'barang_kode' => 'HP002', 'barang_nama' => 'Handphone', 'harga_beli' => 3000000, 'harga_jual' => 3500000],
            ['barang_id' => 3, 'kategori_id' => 2, 'barang_kode' => 'SH001', 'barang_nama' => 'Sepatu', 'harga_beli' => 500000, 'harga_jual' => 700000],
            ['barang_id' => 4, 'kategori_id' => 3, 'barang_kode' => 'RC001', 'barang_nama' => 'Roti Coklat', 'harga_beli' => 5000, 'harga_jual' => 7000],
            ['barang_id' => 5, 'kategori_id' => 3, 'barang_kode' => 'RC002', 'barang_nama' => 'Roti Keju', 'harga_beli' => 6000, 'harga_jual' => 8000],
            ['barang_id' => 6, 'kategori_id' => 4, 'barang_kode' => 'A001', 'barang_nama' => 'Air Mineral', 'harga_beli' => 2000, 'harga_jual' => 4000],
            ['barang_id' => 7, 'kategori_id' => 4, 'barang_kode' => 'JD001', 'barang_nama' => 'Jus Jeruk', 'harga_beli' => 10000, 'harga_jual' => 12000],
            ['barang_id' => 8, 'kategori_id' => 5, 'barang_kode' => 'BK001', 'barang_nama' => 'Buku Novel', 'harga_beli' => 50000, 'harga_jual' => 70000],
            ['barang_id' => 9, 'kategori_id' => 5, 'barang_kode' => 'BK002', 'barang_nama' => 'Buku Pelajaran', 'harga_beli' => 60000, 'harga_jual' => 80000],
            ['barang_id' => 10, 'kategori_id' => 5, 'barang_kode' => 'BK003', 'barang_nama' => 'Buku Komik', 'harga_beli' => 30000, 'harga_jual' => 50000],
        ];

        DB::table('m_barang')->insert($data);
    }
}
