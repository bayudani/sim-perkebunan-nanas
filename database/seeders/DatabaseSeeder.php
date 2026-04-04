<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin (Bisa input data)
        User::create([
            'name' => 'Admin Kebun',
            'username' => 'admin',
            'email' => 'admin@kebun.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Akun Pengelola (Hanya bisa lihat & cetak laporan)
        User::create([
            'name' => 'Pengelola',
            'username' => 'pengelola',
            'email' => 'pengelola@kebun.com',
            'password' => Hash::make('password'), 
            'role' => 'pengelola',
        ]);
    }
}