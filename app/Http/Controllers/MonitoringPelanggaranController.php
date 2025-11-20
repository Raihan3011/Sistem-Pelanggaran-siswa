<?php

namespace App\Http\Controllers;

use App\Models\MonitoringPelanggaran;
use App\Models\Pelanggaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringPelanggaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->level === 'kepala_sekolah') {
            // Kepala sekolah hanya melihat monitoring yang mereka tangani
            $monitoring = MonitoringPelanggaran::with(['pelanggaran.siswa.kelas', 'pelanggaran.jenisPelanggaran'])
                ->where('guru_kepsek', $user->user_id)
                ->orderBy('tanggal_monitoring', 'desc')
                ->get();
        } else {
            // Admin melihat semua monitoring
            $monitoring = MonitoringPelanggaran::with(['pelanggaran.siswa.kelas', 'pelanggaran.jenisPelanggaran', 'guruKepsek'])
                ->orderBy('tanggal_monitoring', 'desc')
                ->get();
        }
            
        return view('monitoring-pelanggaran.index', compact('monitoring'));
    }

    // ... method lainnya sama seperti sebelumnya, hanya nama class yang diupdate
}