<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\OrangTua;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

class OrangTuaUserSeeder extends Seeder
{
    public function run()
    {
        // Ambil beberapa siswa untuk dibuatkan orang tua
        $siswa = Siswa::take(5)->get();
        
        foreach ($siswa as $s) {
            // Buat user untuk ayah
            $userAyah = User::create([
                'username' => 'ayah_' . $s->nis,
                'password' => Hash::make($s->nis), // Password default = NIS
                'nama_lengkap' => 'Ayah ' . $s->nama_siswa,
                'level' => 'orang_tua',
                'can_verify' => false,
                'is_active' => true,
            ]);
            
            // Buat data orang tua (ayah)
            OrangTua::create([
                'user_id' => $userAyah->user_id,
                'siswa_id' => $s->siswa_id,
                'hubungan' => 'Ayah',
                'nama_orang_tua' => 'Ayah ' . $s->nama_siswa,
                'pekerjaan' => 'Karyawan Swasta',
                'pendidikan' => 'SMA',
                'no_telp' => '08123456' . str_pad($s->siswa_id, 3, '0', STR_PAD_LEFT),
                'alamat' => $s->alamat,
            ]);
            
            // Buat user untuk ibu
            $userIbu = User::create([
                'username' => 'ibu_' . $s->nis,
                'password' => Hash::make($s->nis), // Password default = NIS
                'nama_lengkap' => 'Ibu ' . $s->nama_siswa,
                'level' => 'orang_tua',
                'can_verify' => false,
                'is_active' => true,
            ]);
            
            // Buat data orang tua (ibu)
            OrangTua::create([
                'user_id' => $userIbu->user_id,
                'siswa_id' => $s->siswa_id,
                'hubungan' => 'Ibu',
                'nama_orang_tua' => 'Ibu ' . $s->nama_siswa,
                'pekerjaan' => 'Ibu Rumah Tangga',
                'pendidikan' => 'SMA',
                'no_telp' => '08123457' . str_pad($s->siswa_id, 3, '0', STR_PAD_LEFT),
                'alamat' => $s->alamat,
            ]);
        }
    }
}