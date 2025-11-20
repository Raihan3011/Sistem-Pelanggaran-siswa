<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'nama_lengkap' => 'Administrator',
            'level' => 'admin',
            'can_verify' => true,
            'is_active' => true,
        ]);
    }
}