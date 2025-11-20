<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\JenisPelanggaran;
use App\Models\OrangTua;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        \Log::info('Dashboard accessed by user: ' . $user->username . ' with level: ' . $user->level);
        
        // Strict role-based routing dengan switch untuk performa lebih baik
        switch ($user->level) {
            case 'admin':
                return $this->adminDashboard();
                
            case 'orang_tua':
                $orangTua = \App\Models\OrangTua::where('user_id', $user->user_id)->first();
                return $this->orangTuaDashboard($orangTua);
                
            case 'kepsek':
                return $this->kepsekDashboard();
                
            case 'kesiswaan':
                return $this->kesiswaanDashboard();
                
            case 'bk':
                return $this->bkDashboard();
                
            case 'wali_kelas':
                return $this->waliKelasDashboard();
                
            case 'guru':
                return $this->guruDashboard();
                
            case 'siswa':
                \Log::info('User is siswa, fetching siswa data...');
                $siswa = \App\Models\Siswa::where('user_id', $user->user_id)->first();
                \Log::info('Siswa data: ' . ($siswa ? 'Found - ID: ' . $siswa->siswa_id : 'Not Found'));
                return $this->siswaDashboard($siswa);
                
            default:
                \Log::warning('Unknown user level: ' . $user->level . ', using default dashboard');
                return $this->defaultDashboard();
        }
    }
    
    private function orangTuaDashboard($orangTua)
    {
        try {
            if (!$orangTua || !$orangTua->siswa_id) {
                $siswa = (object) [
                    'siswa_id' => null,
                    'nama_siswa' => 'Belum Tersambung',
                    'nis' => '-',
                    'nisn' => '-',
                    'jenis_kelamin' => '-',
                    'kelas' => (object) ['nama_kelas' => '-']
                ];
                $totalPelanggaran = $pelanggaranBulanIni = $totalPoin = 0;
                $recentViolations = $monthlyViolations = $sanksi = $bimbinganKonseling = collect();
            } else {
                $siswa = Siswa::with('kelas')->find($orangTua->siswa_id);
                
                if (!$siswa) {
                    $siswa = (object) [
                        'siswa_id' => null,
                        'nama_siswa' => 'Data Tidak Ditemukan',
                        'nis' => '-',
                        'nisn' => '-',
                        'jenis_kelamin' => '-',
                        'kelas' => (object) ['nama_kelas' => '-']
                    ];
                    $totalPelanggaran = $pelanggaranBulanIni = $totalPoin = 0;
                    $recentViolations = $monthlyViolations = $sanksi = $bimbinganKonseling = collect();
                } else {
                    $totalPelanggaran = Pelanggaran::where('siswa_id', $siswa->siswa_id)->count();
                    $pelanggaranBulanIni = Pelanggaran::where('siswa_id', $siswa->siswa_id)->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->count();
                    $totalPoin = Pelanggaran::where('siswa_id', $siswa->siswa_id)->sum('point');
                    $recentViolations = Pelanggaran::where('siswa_id', $siswa->siswa_id)->with(['jenisPelanggaran'])->orderBy('tanggal', 'desc')->limit(10)->get();
                    $monthlyViolations = Pelanggaran::where('siswa_id', $siswa->siswa_id)->select(DB::raw('MONTH(tanggal) as month'), DB::raw('COUNT(*) as total'))->whereYear('tanggal', date('Y'))->groupBy('month')->orderBy('month')->get();
                    $sanksi = \App\Models\Sanksi::whereHas('pelanggaran', function($q) use ($siswa) { $q->where('siswa_id', $siswa->siswa_id); })->with(['pelanggaran.jenisPelanggaran'])->orderBy('created_at', 'desc')->get();
                    $bimbinganKonseling = \App\Models\BimbinganKonseling::where('siswa_id', $siswa->siswa_id)->with(['guruKonselor'])->get();
                }
            }
        } catch (\Exception $e) {
            \Log::error('Error di orangTuaDashboard: ' . $e->getMessage());
            $siswa = (object) [
                'siswa_id' => null,
                'nama_siswa' => 'Belum Tersambung',
                'nis' => '-',
                'nisn' => '-',
                'jenis_kelamin' => '-',
                'kelas' => (object) ['nama_kelas' => '-']
            ];
            $totalPelanggaran = $pelanggaranBulanIni = $totalPoin = 0;
            $recentViolations = $monthlyViolations = $sanksi = $bimbinganKonseling = collect();
        }
        return view('dashboard.orangtua', compact('siswa', 'orangTua', 'totalPelanggaran', 'pelanggaranBulanIni', 'totalPoin', 'recentViolations', 'monthlyViolations', 'sanksi', 'bimbinganKonseling'));
    }
    
    private function adminDashboard()
    {
        try {
            $totalSiswa = Siswa::count();
            $totalPelanggaran = Pelanggaran::count();
            $totalJenisPelanggaran = JenisPelanggaran::count();
            $totalUsers = User::count();
            $totalSanksi = \App\Models\Sanksi::count();
            $recentViolations = Pelanggaran::with(['siswa', 'jenisPelanggaran'])->orderBy('created_at', 'desc')->limit(10)->get();
            $monthlyViolations = Pelanggaran::select(DB::raw('MONTH(tanggal) as month'), DB::raw('COUNT(*) as total'))->whereYear('tanggal', date('Y'))->groupBy('month')->orderBy('month')->get();
            $topViolations = JenisPelanggaran::withCount('pelanggaran')->orderBy('pelanggaran_count', 'desc')->limit(5)->get();
        } catch (\Exception $e) {
            $totalSiswa = $totalPelanggaran = $totalJenisPelanggaran = $totalUsers = $totalSanksi = 0;
            $recentViolations = $monthlyViolations = $topViolations = collect();
        }
        return view('dashboard.admin', compact('totalSiswa', 'totalPelanggaran', 'totalJenisPelanggaran', 'totalUsers', 'totalSanksi', 'recentViolations', 'monthlyViolations', 'topViolations'));
    }
    
    private function defaultDashboard()
    {
        try {
            $user = auth()->user();
            $totalSiswa = User::where('level', 'siswa')->count();
            $totalPelanggaran = Pelanggaran::count();
            $totalJenisPelanggaran = JenisPelanggaran::count();
            $totalUsers = User::count();
            $recentViolations = Pelanggaran::with(['siswa', 'jenisPelanggaran'])->orderBy('created_at', 'desc')->limit(5)->get();
            $monthlyViolations = Pelanggaran::select(DB::raw('MONTH(tanggal) as month'), DB::raw('COUNT(*) as total'))->whereYear('tanggal', date('Y'))->groupBy('month')->orderBy('month')->get();
            $topViolations = JenisPelanggaran::withCount('pelanggaran')->orderBy('pelanggaran_count', 'desc')->limit(5)->get();
            $recentOrangTua = OrangTua::with('siswa')->orderBy('created_at', 'desc')->limit(5)->get();
            
            if (in_array($user->level, ['wali_kelas', 'guru'])) {
                $siswaList = User::where('level', 'siswa')
                    ->with(['siswa.kelas'])
                    ->whereHas('siswa')
                    ->orderBy('nama_lengkap')
                    ->limit(10)
                    ->get();
            } else {
                $siswaList = collect();
            }
        } catch (\Exception $e) {
            $totalSiswa = $totalPelanggaran = $totalJenisPelanggaran = 0;
            $totalUsers = User::count();
            $recentViolations = $monthlyViolations = $topViolations = $recentOrangTua = $siswaList = collect();
        }
        return view('dashboard.index', compact('totalSiswa', 'totalPelanggaran', 'totalJenisPelanggaran', 'totalUsers', 'recentViolations', 'monthlyViolations', 'topViolations', 'recentOrangTua', 'siswaList'));
    }
    
    private function kesiswaanDashboard()
    {
        try {
            $totalSiswa = Siswa::count();
            $totalPelanggaran = Pelanggaran::count();
            $pelanggaranPending = Pelanggaran::where('status_verifikasi', 'Pending')->count();
            $totalSanksi = \App\Models\Sanksi::count();
            $recentViolations = Pelanggaran::with(['siswa', 'jenisPelanggaran'])->orderBy('created_at', 'desc')->limit(10)->get();
            $monthlyViolations = Pelanggaran::select(DB::raw('MONTH(tanggal) as month'), DB::raw('COUNT(*) as total'))->whereYear('tanggal', date('Y'))->groupBy('month')->orderBy('month')->get();
            $topViolations = JenisPelanggaran::withCount('pelanggaran')->orderBy('pelanggaran_count', 'desc')->limit(5)->get();
            $violationsByCategory = JenisPelanggaran::select('kategori', DB::raw('COUNT(*) as total'))->join('pelanggaran', 'jenis_pelanggaran.jenis_pelanggaran_id', '=', 'pelanggaran.jenis_pelanggaran_id')->groupBy('kategori')->get();
        } catch (\Exception $e) {
            $totalSiswa = $totalPelanggaran = $pelanggaranPending = $totalSanksi = 0;
            $recentViolations = $monthlyViolations = $topViolations = $violationsByCategory = collect();
        }
        return view('dashboard.kesiswaan', compact('totalSiswa', 'totalPelanggaran', 'pelanggaranPending', 'totalSanksi', 'recentViolations', 'monthlyViolations', 'topViolations', 'violationsByCategory'));
    }
    
    private function siswaDashboard($siswa = null)
    {
        // Jika siswa null (user level siswa tapi belum ada di tabel siswa), buat data dummy
        if (!$siswa) {
            $user = auth()->user();
            $siswa = (object) [
                'siswa_id' => null,
                'nama_siswa' => $user->nama_lengkap,
                'nis' => '-',
                'kelas' => (object) ['nama_kelas' => 'Belum ditentukan']
            ];
            $totalPelanggaran = $pelanggaranBulanIni = $totalPoin = $totalPrestasi = 0;
            $recentViolations = $monthlyViolations = $sanksi = $prestasi = collect();
        } else {
            \Log::info('Masuk ke siswaDashboard untuk siswa: ' . $siswa->nama_siswa);
            try {
                $totalPelanggaran = Pelanggaran::where('siswa_id', $siswa->siswa_id)->count();
                $pelanggaranBulanIni = Pelanggaran::where('siswa_id', $siswa->siswa_id)->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->count();
                $totalPoin = Pelanggaran::where('siswa_id', $siswa->siswa_id)->sum('point');
                $recentViolations = Pelanggaran::where('siswa_id', $siswa->siswa_id)->with(['jenisPelanggaran'])->orderBy('tanggal', 'desc')->limit(10)->get();
                $monthlyViolations = Pelanggaran::where('siswa_id', $siswa->siswa_id)->select(DB::raw('MONTH(tanggal) as month'), DB::raw('COUNT(*) as total'))->whereYear('tanggal', date('Y'))->groupBy('month')->orderBy('month')->get();
                $sanksi = \App\Models\Sanksi::whereHas('pelanggaran', function($q) use ($siswa) { $q->where('siswa_id', $siswa->siswa_id); })->with(['pelanggaran.jenisPelanggaran'])->orderBy('created_at', 'desc')->get();
                $prestasi = \App\Models\Prestasi::where('siswa_id', $siswa->siswa_id)->with(['jenisPrestasi'])->orderBy('tanggal', 'desc')->limit(10)->get();
                $totalPrestasi = \App\Models\Prestasi::where('siswa_id', $siswa->siswa_id)->count();
            } catch (\Exception $e) {
                \Log::error('Error di siswaDashboard: ' . $e->getMessage());
                $totalPelanggaran = $pelanggaranBulanIni = $totalPoin = $totalPrestasi = 0;
                $recentViolations = $monthlyViolations = $sanksi = $prestasi = collect();
            }
        }
        \Log::info('Return view dashboard.siswa');
        return view('dashboard.siswa', compact('siswa', 'totalPelanggaran', 'pelanggaranBulanIni', 'totalPoin', 'recentViolations', 'monthlyViolations', 'sanksi', 'prestasi', 'totalPrestasi'));
    }
    
    private function kepsekDashboard()
    {
        try {
            $totalSiswa = Siswa::count();
            $totalPelanggaran = Pelanggaran::count();
            $totalJenisPelanggaran = JenisPelanggaran::count();
            $totalSanksi = \App\Models\Sanksi::count();
            $recentViolations = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])->orderBy('created_at', 'desc')->limit(10)->get();
            $monthlyViolations = Pelanggaran::select(DB::raw('MONTH(tanggal) as month'), DB::raw('COUNT(*) as total'))->whereYear('tanggal', date('Y'))->groupBy('month')->orderBy('month')->get();
            $topViolations = JenisPelanggaran::withCount('pelanggaran')->orderBy('pelanggaran_count', 'desc')->limit(5)->get();
        } catch (\Exception $e) {
            $totalSiswa = $totalPelanggaran = $totalJenisPelanggaran = $totalSanksi = 0;
            $recentViolations = $monthlyViolations = $topViolations = collect();
        }
        return view('dashboard.kepsek', compact('totalSiswa', 'totalPelanggaran', 'totalJenisPelanggaran', 'totalSanksi', 'recentViolations', 'monthlyViolations', 'topViolations'));
    }
    
    private function bkDashboard()
    {
        try {
            $totalPelanggaran = Pelanggaran::count();
            $siswaBermasalah = Siswa::whereHas('pelanggaran')->distinct()->count('siswa_id');
            
            // Data bimbingan konseling (dummy data - nanti bisa diganti dengan data real dari database)
            $bimbinganKonseling = [
                [
                    'tanggal' => '15/01/2024',
                    'siswa' => 'Ahmad Fauzi',
                    'kelas' => 'X RPL 1',
                    'topik' => 'Masalah Kedisiplinan',
                    'masalah' => 'Sering terlambat masuk kelas dan tidak mengerjakan tugas',
                    'solusi' => 'Membuat jadwal harian dan komitmen untuk datang tepat waktu',
                    'status' => 'Proses'
                ],
                [
                    'tanggal' => '12/01/2024',
                    'siswa' => 'Siti Nurhaliza',
                    'kelas' => 'XI TKJ 2',
                    'topik' => 'Konflik dengan Teman',
                    'masalah' => 'Terlibat pertengkaran dengan teman sekelas',
                    'solusi' => 'Mediasi antara kedua pihak dan membuat kesepakatan damai',
                    'status' => 'Selesai'
                ],
                [
                    'tanggal' => '10/01/2024',
                    'siswa' => 'Budi Santoso',
                    'kelas' => 'XII MM 1',
                    'topik' => 'Motivasi Belajar',
                    'masalah' => 'Kehilangan motivasi belajar dan nilai menurun drastis',
                    'solusi' => 'Konseling motivasi dan membuat target belajar jangka pendek',
                    'status' => 'Proses'
                ],
            ];
            
            $totalBimbingan = count($bimbinganKonseling);
            $bimbinganSelesai = collect($bimbinganKonseling)->where('status', 'Selesai')->count();
            
            // Siswa dengan poin tertinggi (prioritas bimbingan)
            $siswaPrioritas = Siswa::with('kelas')
                ->withSum('pelanggaran as total_poin', 'point')
                ->having('total_poin', '>', 0)
                ->orderBy('total_poin', 'desc')
                ->limit(10)
                ->get();
            
            // Kategori pelanggaran
            $kategoriPelanggaran = JenisPelanggaran::select('kategori', DB::raw('COUNT(*) as total'))
                ->join('pelanggaran', 'jenis_pelanggaran.jenis_pelanggaran_id', '=', 'pelanggaran.jenis_pelanggaran_id')
                ->groupBy('kategori')
                ->get();
            
            // Pelanggaran terbaru yang perlu ditindaklanjuti
            $pelanggaranTerbaru = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
                ->whereHas('jenisPelanggaran', function($q) {
                    $q->whereIn('kategori', ['Sedang', 'Berat']);
                })
                ->orderBy('tanggal', 'desc')
                ->limit(10)
                ->get();
        } catch (\Exception $e) {
            $totalPelanggaran = $siswaBermasalah = $totalBimbingan = $bimbinganSelesai = 0;
            $siswaPrioritas = $kategoriPelanggaran = $pelanggaranTerbaru = collect();
            $bimbinganKonseling = [];
        }
        return view('dashboard.bk', compact('totalPelanggaran', 'siswaBermasalah', 'totalBimbingan', 'bimbinganSelesai', 'siswaPrioritas', 'kategoriPelanggaran', 'pelanggaranTerbaru', 'bimbinganKonseling'));
    }
    
    private function guruDashboard()
    {
        try {
            $user = auth()->user();
            $totalSiswa = Siswa::count();
            $pelanggaranHariIni = Pelanggaran::where('guru_pencatat', $user->user_id)
                ->whereDate('tanggal', today())
                ->count();
            $pelanggaranBulanIni = Pelanggaran::where('guru_pencatat', $user->user_id)
                ->whereMonth('tanggal', date('m'))
                ->whereYear('tanggal', date('Y'))
                ->count();
            $siswaList = User::where('level', 'siswa')
                ->with(['siswa.kelas'])
                ->orderBy('nama_lengkap')
                ->limit(10)
                ->get();
            $recentPelanggaran = Pelanggaran::where('guru_pencatat', $user->user_id)
                ->with(['siswa.kelas', 'jenisPelanggaran'])
                ->orderBy('tanggal', 'desc')
                ->limit(5)
                ->get();
            
            $jadwalPelajaran = [
                ['hari' => 'Senin', 'jam' => '07:00 - 08:30', 'kelas' => 'X RPL 1', 'mapel' => 'Pemrograman Dasar'],
                ['hari' => 'Senin', 'jam' => '08:30 - 10:00', 'kelas' => 'X RPL 2', 'mapel' => 'Pemrograman Dasar'],
                ['hari' => 'Selasa', 'jam' => '07:00 - 08:30', 'kelas' => 'XI RPL 1', 'mapel' => 'Basis Data'],
                ['hari' => 'Rabu', 'jam' => '09:00 - 10:30', 'kelas' => 'XII RPL 1', 'mapel' => 'Pemrograman Web'],
            ];
        } catch (\Exception $e) {
            $totalSiswa = $pelanggaranHariIni = $pelanggaranBulanIni = 0;
            $siswaList = $recentPelanggaran = collect();
            $jadwalPelajaran = [];
        }
        return view('dashboard.guru', compact('totalSiswa', 'pelanggaranHariIni', 'pelanggaranBulanIni', 'siswaList', 'recentPelanggaran', 'jadwalPelajaran'));
    }
    
    private function waliKelasDashboard()
    {
        try {
            $user = auth()->user();
            $kelas = \App\Models\Kelas::where('wali_kelas_id', $user->user_id)->first();
            
            if ($kelas) {
                $siswaList = User::where('level', 'siswa')
                    ->with(['siswa.kelas'])
                    ->whereHas('siswa', function($q) use ($kelas) {
                        $q->where('kelas_id', $kelas->kelas_id);
                    })
                    ->get();
                $totalSiswa = $siswaList->count();
                $pelanggaranKelas = Pelanggaran::whereIn('siswa_id', $siswaList->pluck('siswa_id'))->count();
                $recentPelanggaran = Pelanggaran::whereIn('siswa_id', $siswaList->pluck('siswa_id'))
                    ->with(['siswa', 'jenisPelanggaran'])
                    ->orderBy('tanggal', 'desc')
                    ->limit(10)
                    ->get();
            } else {
                $kelas = null;
                $siswaList = collect();
                $totalSiswa = 0;
                $pelanggaranKelas = 0;
                $recentPelanggaran = collect();
            }
        } catch (\Exception $e) {
            $kelas = null;
            $siswaList = collect();
            $totalSiswa = 0;
            $pelanggaranKelas = 0;
            $recentPelanggaran = collect();
        }
        return view('dashboard.wali-kelas', compact('kelas', 'siswaList', 'totalSiswa', 'pelanggaranKelas', 'recentPelanggaran'));
    }
}