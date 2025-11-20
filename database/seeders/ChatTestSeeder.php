<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use App\Models\OrangTua;
use App\Models\Kelas;

class ChatTestSeeder extends Seeder
{
    public function run()
    {
        // Create kelas if not exists
        $kelas = Kelas::firstOrCreate(
            ['nama_kelas' => 'X PPLG 1'],
            ['jurusan' => 'PPLG', 'kapasitas' => 36, 'wali_kelas_id' => 5]
        );

        // Create siswa if not exists
        $siswaUser = User::find(8);
        $siswa = Siswa::firstOrCreate(
            ['user_id' => 8],
            [
                'nis' => '12345',
                'nisn' => '1234567890',
                'nama_siswa' => 'siswa',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2005-01-01',
                'tempat_lahir' => 'Bandung',
                'alamat' => 'Jl. Test',
                'no_telp' => '08123456789',
                'kelas_id' => $kelas->kelas_id
            ]
        );

        // Create orang_tua linked to user and siswa
        OrangTua::firstOrCreate(
            ['user_id' => 7],
            [
                'siswa_id' => $siswa->siswa_id,
                'hubungan' => 'Ayah',
                'nama_orang_tua' => 'ortu',
                'pekerjaan' => 'Wiraswasta',
                'pendidikan' => 'S1',
                'no_telp' => '08123456789',
                'alamat' => 'Jl. Test'
            ]
        );

        $this->command->info('Chat test data created successfully!');
    }
}
