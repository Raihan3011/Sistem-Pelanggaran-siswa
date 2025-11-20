<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisPrestasi;

class JenisPrestasiSeeder extends Seeder
{
    public function run(): void
    {
        $jenisPrestasiData = [
            ['nama_prestasi' => 'Prestasi Umum', 'jenis' => 'Akademik', 'kategori' => 'Sekolah', 'deskripsi' => 'Prestasi akademik tingkat sekolah', 'reward' => '10 poin'],
            ['nama_prestasi' => 'Juara Olimpiade', 'jenis' => 'Akademik', 'kategori' => 'Nasional', 'deskripsi' => 'Juara olimpiade tingkat nasional', 'reward' => '75 poin'],
            ['nama_prestasi' => 'Juara Olahraga', 'jenis' => 'Olahraga', 'kategori' => 'Provinsi', 'deskripsi' => 'Juara olahraga tingkat provinsi', 'reward' => '50 poin'],
            ['nama_prestasi' => 'Juara Seni', 'jenis' => 'Seni', 'kategori' => 'Kota', 'deskripsi' => 'Juara seni tingkat kota', 'reward' => '30 poin'],
        ];

        foreach ($jenisPrestasiData as $data) {
            JenisPrestasi::create($data);
        }
    }
}
