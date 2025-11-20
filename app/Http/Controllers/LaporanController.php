<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        $kelas = Kelas::orderBy('tingkat')->orderBy('jurusan')->orderBy('rombel')->get();
        $siswa = Siswa::with('kelas')->orderBy('nama_siswa')->get();
        return view('laporan.index', compact('kelas', 'siswa'));
    }

    public function harian(Request $request)
    {
        $tanggal = $request->tanggal ?? date('Y-m-d');
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])
            ->whereDate('tanggal', $tanggal)
            ->orderBy('tanggal', 'desc')
            ->get();
        
        $pdf = Pdf::loadView('laporan.cetak-harian', compact('pelanggaran', 'tanggal'));
        return $pdf->download('laporan-harian-' . $tanggal . '.pdf');
    }

    public function bulanan(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');
        
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'desc')
            ->get();
        
        $pdf = Pdf::loadView('laporan.cetak-bulanan', compact('pelanggaran', 'bulan', 'tahun'));
        return $pdf->download('laporan-bulanan-' . $bulan . '-' . $tahun . '.pdf');
    }

    public function kelas(Request $request)
    {
        $kelas_id = $request->kelas_id;
        $kelas = Kelas::findOrFail($kelas_id);
        
        $pelanggaran = Pelanggaran::with(['siswa', 'jenisPelanggaran', 'guruPencatat'])
            ->whereHas('siswa', function($q) use ($kelas_id) {
                $q->where('kelas_id', $kelas_id);
            })
            ->orderBy('tanggal', 'desc')
            ->get();
        
        $pdf = Pdf::loadView('laporan.cetak-kelas', compact('pelanggaran', 'kelas'));
        return $pdf->download('laporan-kelas-' . $kelas->nama_kelas . '.pdf');
    }

    public function siswa(Request $request)
    {
        $siswa_id = $request->siswa_id;
        $siswa = Siswa::with('kelas')->findOrFail($siswa_id);
        
        $pelanggaran = Pelanggaran::with(['jenisPelanggaran', 'guruPencatat'])
            ->where('siswa_id', $siswa_id)
            ->orderBy('tanggal', 'desc')
            ->get();
        
        $pdf = Pdf::loadView('laporan.cetak-siswa', compact('pelanggaran', 'siswa'));
        return $pdf->download('laporan-siswa-' . $siswa->nis . '.pdf');
    }
    
    public function waliKelas()
    {
        $user = auth()->user();
        $kelas = Kelas::where('wali_kelas_id', $user->user_id)->first();
        
        if (!$kelas) {
            return redirect()->route('dashboard')->with('error', 'Anda belum ditugaskan sebagai wali kelas.');
        }
        
        return view('laporan.wali-kelas', compact('kelas'));
    }
    
    public function waliKelasPdf(Request $request)
    {
        $user = auth()->user();
        $kelas = Kelas::where('wali_kelas_id', $user->user_id)->first();
        
        if (!$kelas) {
            return redirect()->route('dashboard')->with('error', 'Anda belum ditugaskan sebagai wali kelas.');
        }
        
        $siswa = Siswa::where('kelas_id', $kelas->kelas_id)->get();
        $pelanggaran = Pelanggaran::with(['siswa', 'jenisPelanggaran', 'guruPencatat'])
            ->whereHas('siswa', function($q) use ($kelas) {
                $q->where('kelas_id', $kelas->kelas_id);
            })
            ->orderBy('tanggal', 'desc')
            ->get();
        
        $pdf = Pdf::loadView('laporan.cetak-wali-kelas', compact('kelas', 'siswa', 'pelanggaran'));
        return $pdf->download('laporan-kelas-' . $kelas->nama_kelas . '-' . date('Y-m-d') . '.pdf');
    }
    
    public function kesiswaan()
    {
        return view('laporan.kesiswaan');
    }
    
    public function kesiswaanPdf(Request $request)
    {
        $siswa = Siswa::with('kelas')->get();
        $kelas = Kelas::withCount('siswa')->get();
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])
            ->orderBy('tanggal', 'desc')
            ->get();
        
        $statistik = [
            'total_siswa' => $siswa->count(),
            'total_kelas' => $kelas->count(),
            'total_pelanggaran' => $pelanggaran->count(),
            'pelanggaran_terverifikasi' => $pelanggaran->where('status_verifikasi', 'Terverifikasi')->count(),
            'pelanggaran_pending' => $pelanggaran->where('status_verifikasi', 'Pending')->count(),
        ];
        
        $pdf = Pdf::loadView('laporan.cetak-kesiswaan', compact('siswa', 'kelas', 'pelanggaran', 'statistik'));
        return $pdf->download('laporan-kesiswaan-' . date('Y-m-d') . '.pdf');
    }
    
    public function bk()
    {
        return view('laporan.bk');
    }
    
    public function bkPdf(Request $request)
    {
        $bimbingan = \App\Models\BimbinganKonseling::with(['siswa.kelas', 'guruKonselor'])
            ->get();
        
        $siswa = Siswa::with('kelas')->get();
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
            ->orderBy('tanggal', 'desc')
            ->get();
        
        $statistik = [
            'total_bimbingan' => $bimbingan->count(),
            'total_siswa_dibimbing' => $bimbingan->unique('siswa_id')->count(),
            'total_pelanggaran' => $pelanggaran->count(),
        ];
        
        $pdf = Pdf::loadView('laporan.cetak-bk', compact('bimbingan', 'siswa', 'pelanggaran', 'statistik'));
        return $pdf->download('laporan-bk-' . date('Y-m-d') . '.pdf');
    }
}
