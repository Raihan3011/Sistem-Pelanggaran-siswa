<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

class SiswaUserSeeder extends Seeder
{
    public function run()
    {
        // Ambil siswa yang belum punya user_id
        $siswa = Siswa::whereNull('user_id')->get();
        
        foreach ($siswa as $s) {
            // Buat user untuk siswa
            $userSiswa = User::create([
                'username' => $s->nis,
                'password' => Hash::make($s->nis), // Password = NIS
                'nama_lengkap' => $s->nama_siswa,
                'level' => 'siswa',
                'can_verify' => false,
                'is_active' => true,
            ]);
            
            // Update siswa dengan user_id
            $s->update(['user_id' => $userSiswa->user_id]);
        }
    }
}