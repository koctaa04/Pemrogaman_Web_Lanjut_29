<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_user')->insert([
            [
                'level_id' => 1, // Admin
                'username' => 'admin',
                'nama' => 'Administrator',
                'password' => Hash::make('123456'),
            ],
            [
                'level_id' => 2, // Kasir/Staff
                'username' => 'staff',
                'nama' => 'Staff/Kasir',
                'password' => Hash::make('123456'),
            ],
        ]);
    }
}
