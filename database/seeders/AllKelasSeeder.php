<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class AllKelasSeeder extends Seeder
{
    public function run()
    {
        $kelasData = [
            // Kelas X
            ['nama_kelas' => 'X PPLG 1', 'tingkat' => 'X', 'jurusan' => 'PPLG', 'rombel' => '1', 'kapasitas' => 36],
            ['nama_kelas' => 'X PPLG 2', 'tingkat' => 'X', 'jurusan' => 'PPLG', 'rombel' => '2', 'kapasitas' => 36],
            ['nama_kelas' => 'X PPLG 3', 'tingkat' => 'X', 'jurusan' => 'PPLG', 'rombel' => '3', 'kapasitas' => 36],
            ['nama_kelas' => 'X AKT 1', 'tingkat' => 'X', 'jurusan' => 'AKT', 'rombel' => '1', 'kapasitas' => 36],
            ['nama_kelas' => 'X AKT 2', 'tingkat' => 'X', 'jurusan' => 'AKT', 'rombel' => '2', 'kapasitas' => 36],
            ['nama_kelas' => 'X BDP 1', 'tingkat' => 'X', 'jurusan' => 'BDP', 'rombel' => '1', 'kapasitas' => 36],
            ['nama_kelas' => 'X DKV 1', 'tingkat' => 'X', 'jurusan' => 'DKV', 'rombel' => '1', 'kapasitas' => 36],
            ['nama_kelas' => 'X ANM 1', 'tingkat' => 'X', 'jurusan' => 'ANM', 'rombel' => '1', 'kapasitas' => 36],
            
            // Kelas XI
            ['nama_kelas' => 'XI PPLG 1', 'tingkat' => 'XI', 'jurusan' => 'PPLG', 'rombel' => '1', 'kapasitas' => 36],
            ['nama_kelas' => 'XI PPLG 2', 'tingkat' => 'XI', 'jurusan' => 'PPLG', 'rombel' => '2', 'kapasitas' => 36],
            ['nama_kelas' => 'XI PPLG 3', 'tingkat' => 'XI', 'jurusan' => 'PPLG', 'rombel' => '3', 'kapasitas' => 36],
            ['nama_kelas' => 'XI AKT 1', 'tingkat' => 'XI', 'jurusan' => 'AKT', 'rombel' => '1', 'kapasitas' => 36],
            ['nama_kelas' => 'XI AKT 2', 'tingkat' => 'XI', 'jurusan' => 'AKT', 'rombel' => '2', 'kapasitas' => 36],
            ['nama_kelas' => 'XI BDP 1', 'tingkat' => 'XI', 'jurusan' => 'BDP', 'rombel' => '1', 'kapasitas' => 36],
            ['nama_kelas' => 'XI DKV 1', 'tingkat' => 'XI', 'jurusan' => 'DKV', 'rombel' => '1', 'kapasitas' => 36],
            ['nama_kelas' => 'XI ANM 1', 'tingkat' => 'XI', 'jurusan' => 'ANM', 'rombel' => '1', 'kapasitas' => 36],
            
            // Kelas XII
            ['nama_kelas' => 'XII PPLG 1', 'tingkat' => 'XII', 'jurusan' => 'PPLG', 'rombel' => '1', 'kapasitas' => 36],
            ['nama_kelas' => 'XII PPLG 2', 'tingkat' => 'XII', 'jurusan' => 'PPLG', 'rombel' => '2', 'kapasitas' => 36],
            ['nama_kelas' => 'XII PPLG 3', 'tingkat' => 'XII', 'jurusan' => 'PPLG', 'rombel' => '3', 'kapasitas' => 36],
            ['nama_kelas' => 'XII AKT 1', 'tingkat' => 'XII', 'jurusan' => 'AKT', 'rombel' => '1', 'kapasitas' => 36],
            ['nama_kelas' => 'XII AKT 2', 'tingkat' => 'XII', 'jurusan' => 'AKT', 'rombel' => '2', 'kapasitas' => 36],
            ['nama_kelas' => 'XII BDP 1', 'tingkat' => 'XII', 'jurusan' => 'BDP', 'rombel' => '1', 'kapasitas' => 36],
            ['nama_kelas' => 'XII DKV 1', 'tingkat' => 'XII', 'jurusan' => 'DKV', 'rombel' => '1', 'kapasitas' => 36],
            ['nama_kelas' => 'XII ANM 1', 'tingkat' => 'XII', 'jurusan' => 'ANM', 'rombel' => '1', 'kapasitas' => 36],
        ];

        foreach ($kelasData as $data) {
            Kelas::updateOrCreate(
                ['nama_kelas' => $data['nama_kelas']],
                $data
            );
        }
    }
}
