<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat akun khusus admin
        User::create([
            'name' => 'Admin Amikom',
            'email' => 'admin@amikom.ac.id',
            'password' => Hash::make('password'), // Password untuk login nanti
            'role' => 'admin', // WAJIB 'admin' agar tidak dilempar keluar oleh middleware
        ]);
    }
}