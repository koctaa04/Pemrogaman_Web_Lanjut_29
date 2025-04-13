<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'supplier_id' => 1,
                'supplier_kode' => 'SPL01',
                'supplier_nama' => 'PT Supplier Sejati',
                'supplier_alamat' => 'Jl. Soekarno-Hatta No. 21, Malang'
            ],
            [
                'supplier_id' => 2,
                'supplier_kode' => 'SPL02',
                'supplier_nama' => 'PT Supplier Utama',
                'supplier_alamat' => 'Jl. Tlogomas No. 34, Malang'
            ],
            [
                'supplier_id' => 3,
                'supplier_kode' => 'SPL03',
                'supplier_nama' => 'PT Supplier Sigma',
                'supplier_alamat' => 'Jl. MT Haryono No. 12A, Malang'
            ],
        ];

        DB::table('m_supplier')->insert($data);
    }
}