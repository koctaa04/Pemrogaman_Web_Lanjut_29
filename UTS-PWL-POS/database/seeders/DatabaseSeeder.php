<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            KategoriSeeder::class,        // Awal program memastikan kategori ada
            BarangSeeder::class,          // Barang membutuhkan kategori_id
            LevelSeeder::class,           // Level jika dibutuhkan
            SupplierSeeder::class,        // Supplier jika dibutuhkan di stok
            UserSeeder::class,            // User jika dibutuhkan
            PenjualanSeeder::class,       // Penjualan membutuhkan user_id
            PenjualanDetailSeeder::class, // PenjualanDetail membutuhkan penjualan_id
            StokSeeder::class,            // Stok membutuhkan barang_id dan supplier_id
        ]);
    }
}
