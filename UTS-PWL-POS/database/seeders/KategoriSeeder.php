<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_kategori')->insert([
            [
                'kategori_nama'  => 'Elektronik',
                'kategori_kode'  => 'ELT',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'kategori_nama'  => 'Pakaian',
                'kategori_kode'  => 'PKA',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'kategori_nama'  => 'Camilan',
                'kategori_kode'  => 'CML',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'kategori_nama'  => 'Buku',
                'kategori_kode'  => 'BKU',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'kategori_nama'  => 'Sepatu',
                'kategori_kode'  => 'SPT',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
