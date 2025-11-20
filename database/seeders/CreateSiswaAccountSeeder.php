<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CreateSiswaAccountSeeder extends Seeder
{
    public function run()
    {
        // Hapus user dengan username siswa1
        User::where('username', 'siswa1')->delete();
        
        // Ambil siswa pertama untuk dijadikan contoh
        $siswa = Siswa::first();
        
        if ($siswa) {
            // Hapus user dengan NIS yang sama jika ada
            User::where('username', $siswa->nis)->delete();
            
            // Buat user untuk siswa
            $userSiswa = User::create([
                'username' => $siswa->nis,
                'password' => Hash::make($siswa->nis),
                'nama_lengkap' => $siswa->nama_siswa,
                'level' => 'siswa',
                'can_verify' => false,
                'is_active' => true,
            ]);
            
            // Update siswa dengan user_id
            $siswa->update(['user_id' => $userSiswa->user_id]);
            
            echo "Akun siswa berhasil dibuat:\n";
            echo "Username: " . $siswa->nis . "\n";
            echo "Password: " . $siswa->nis . "\n";
            echo "Nama: " . $siswa->nama_siswa . "\n";
        }
    }
}