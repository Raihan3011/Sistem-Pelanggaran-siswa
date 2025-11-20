<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tahun_ajaran')->insert([
            'kode_tahun' => '2024/2025',
            'tahun_ajaran' => '2024/2025',
            'semester' => 1,
            'status_aktif' => true,
            'tanggal_mulai' => '2024-07-01',
            'tanggal_selesai' => '2025-06-30',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}