<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Siswa;

class UserObserver
{
    public function created(User $user)
    {
        if ($user->level === 'siswa') {
            $defaultKelas = \App\Models\Kelas::first();
            
            Siswa::create([
                'user_id' => $user->user_id,
                'nis' => 'TEMP' . $user->user_id,
                'nisn' => 'TEMP' . $user->user_id . '00',
                'nama_siswa' => $user->nama_lengkap,
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2000-01-01',
                'tempat_lahir' => '-',
                'alamat' => '-',
                'no_telp' => null,
                'kelas_id' => $defaultKelas ? $defaultKelas->kelas_id : 1,
                'foto' => null,
            ]);
        }
    }

    private function generateNIS()
    {
        $year = date('Y');
        $lastSiswa = Siswa::whereNotNull('nis')
            ->where('nis', 'like', $year . '%')
            ->orderBy('nis', 'desc')
            ->first();
        
        if ($lastSiswa) {
            $lastNumber = (int) substr($lastSiswa->nis, 4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $year . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    private function generateNISN()
    {
        $year = date('Y');
        $lastSiswa = Siswa::whereNotNull('nisn')
            ->where('nisn', 'like', $year . '%')
            ->orderBy('nisn', 'desc')
            ->first();
        
        if ($lastSiswa) {
            $lastNumber = (int) substr($lastSiswa->nisn, 4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $year . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }
}