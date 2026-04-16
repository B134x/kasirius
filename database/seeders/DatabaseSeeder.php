<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account
        User::factory()->create([
            'name'     => 'Admin',
            'nim'      => '2024000001',
            'email'    => 'admin@kasir.app',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Sample karyawan
        User::factory()->create([
            'name'     => 'Karyawan Demo',
            'nim'      => '2024000002',
            'email'    => 'karyawan@kasir.app',
            'password' => Hash::make('password'),
            'role'     => 'karyawan',
        ]);
    }
}
