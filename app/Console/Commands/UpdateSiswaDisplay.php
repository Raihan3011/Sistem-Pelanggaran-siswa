<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Siswa;
use App\Models\Kelas;

class UpdateSiswaDisplay extends Command
{
    protected $signature = 'siswa:update-display';
    protected $description = 'Update siswa display untuk memastikan semua siswa muncul di tabel';

    public function handle()
    {
        $this->info('Memperbarui tampilan siswa...');
        
        // Pastikan semua siswa memiliki data yang lengkap
        $siswa = Siswa::all();
        $updated = 0;
        
        foreach ($siswa as $s) {
            $needUpdate = false;
            $updateData = [];
            
            // Pastikan field yang null diisi dengan default
            if (is_null($s->jenis_kelamin)) {
                $updateData['jenis_kelamin'] = 'L';
                $needUpdate = true;
            }
            
            if (is_null($s->tanggal_lahir)) {
                $updateData['tanggal_lahir'] = '2000-01-01';
                $needUpdate = true;
            }
            
            if (is_null($s->tempat_lahir) || $s->tempat_lahir == '') {
                $updateData['tempat_lahir'] = '-';
                $needUpdate = true;
            }
            
            if (is_null($s->alamat) || $s->alamat == '') {
                $updateData['alamat'] = '-';
                $needUpdate = true;
            }
            
            if ($needUpdate) {
                $s->update($updateData);
                $updated++;
            }
        }
        
        $this->info("Berhasil memperbarui {$updated} data siswa");
        $this->info("Total siswa di database: " . Siswa::count());
        
        // Tampilkan statistik per kelas
        $kelasStats = Kelas::withCount('siswa')->get();
        $this->info("\nStatistik siswa per kelas:");
        foreach ($kelasStats as $kelas) {
            $this->line("- {$kelas->nama_kelas}: {$kelas->siswa_count} siswa");
        }
        
        return 0;
    }
}