<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin Account
        User::create([
            'name' => 'Admin Kuesaena',
            'email' => 'admin@kuesaena.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        // Kasir Account
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@kuesaena.com',
            'role' => 'kasir',
            'password' => Hash::make('kasir123'),
        ]);
    }
}
