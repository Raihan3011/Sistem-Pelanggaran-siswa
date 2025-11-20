<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run()
    {
        $kelasData = [
            ['nama_kelas' => 'X PPLG 1', 'jurusan' => 'PPLG', 'kapasitas' => 36],
            ['nama_kelas' => 'X AKT 1', 'jurusan' => 'AKT', 'kapasitas' => 36],
            ['nama_kelas' => 'X BDP 1', 'jurusan' => 'BDP', 'kapasitas' => 36],
        ];

        foreach ($kelasData as $kelas) {
            Kelas::firstOrCreate(['nama_kelas' => $kelas['nama_kelas']], $kelas);
        }
    }
}