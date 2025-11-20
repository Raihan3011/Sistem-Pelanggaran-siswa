<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateJenisPelanggaranPointSeeder extends Seeder
{
    public function run(): void
    {
        // Update kolom point dengan nilai poin_minimal untuk semua jenis pelanggaran
        DB::statement('UPDATE jenis_pelanggaran SET point = poin_minimal WHERE point = 0');
        
        echo "Kolom point berhasil diupdate dengan nilai poin_minimal\n";
    }
}