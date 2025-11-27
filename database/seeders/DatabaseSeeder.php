<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name' => 'Administrator Utama',
            'email' => 'admin@sipadi.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        // 2. Akun Kader
        User::create([
            'name' => 'Ibu Bidan Desa',
            'email' => 'kader@sipadi.com',
            'password' => Hash::make('kader123'),
            'role' => 'kader'
        ]);

        // 3. Akun Warga (Contoh)
        User::create([
            'name' => 'Budi Santoso (Warga)',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);
    }
}