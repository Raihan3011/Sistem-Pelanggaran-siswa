<?php

namespace App\Http\Controllers;

use App\Models\Sanksi;
use App\Models\Pelanggaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SanksiController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (in_array($request->route()->getActionMethod(), ['create', 'store', 'edit', 'update', 'destroy'])) {
                if (!in_array(auth()->user()->level, ['admin', 'kesiswaan'])) {
                    abort(403, 'Anda tidak memiliki akses untuk melakukan aksi ini.');
                }
            }
            return $next($request);
        });
    }

    public function index()
    {
        $user = Auth::user();
        $orangTua = \App\Models\OrangTua::where('user_id', $user->user_id)->first();
        $siswa = \App\Models\Siswa::where('user_id', $user->user_id)->first();
        
        if ($orangTua) {
            // Orang tua hanya melihat sanksi anaknya
            $sanksi = Sanksi::with(['pelanggaran.siswa.kelas', 'pelanggaran.jenisPelanggaran', 'guruPenanggungJawab'])
                ->whereHas('pelanggaran', function($q) use ($orangTua) {
                    $q->where('siswa_id', $orangTua->siswa_id);
                })
                ->orderBy('tanggal_mulai', 'desc')
                ->get();
        } elseif ($siswa) {
            // Siswa hanya melihat sanksi mereka sendiri
            $sanksi = Sanksi::with(['pelanggaran.siswa.kelas', 'pelanggaran.jenisPelanggaran', 'guruPenanggungJawab'])
                ->whereHas('pelanggaran', function($q) use ($siswa) {
                    $q->where('siswa_id', $siswa->siswa_id);
                })
                ->orderBy('tanggal_mulai', 'desc')
                ->get();
        } else {
            // Admin, Guru, Kesiswaan, BK melihat semua sanksi
            $sanksi = Sanksi::with(['pelanggaran.siswa.kelas', 'pelanggaran.jenisPelanggaran', 'guruPenanggungJawab'])
                ->orderBy('tanggal_mulai', 'desc')
                ->get();
        }
            
        return view('sanksi.index', compact('sanksi'));
    }

    public function create()
    {
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
            ->whereDoesntHave('sanksi')
            ->orderBy('tanggal', 'desc')
            ->get();
            
        $guru = User::whereIn('level', ['guru', 'kesiswaan', 'bk'])->get();
        $jenisSanksi = \App\Models\JenisSanksi::orderBy('poin_minimal')->get();
        
        return view('sanksi.create', compact('pelanggaran', 'guru', 'jenisSanksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggaran,pelanggaran_id',
            'jenis_sanksi' => 'required|max:100',
            'deskripsi_sanksi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'guru_penanggung_jawab' => 'required|exists:users,user_id',
        ]);

        // Cek apakah pelanggaran sudah memiliki sanksi
        $existing = Sanksi::where('pelanggaran_id', $request->pelanggaran_id)->first();
        if ($existing) {
            return back()->with('error', 'Pelanggaran ini sudah memiliki sanksi.');
        }

        $sanksi = Sanksi::create([
            'pelanggaran_id' => $request->pelanggaran_id,
            'jenis_sanksi' => $request->jenis_sanksi,
            'deskripsi_sanksi' => $request->deskripsi_sanksi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'guru_penanggung_jawab' => $request->guru_penanggung_jawab,
        ]);
        
        // Kirim notifikasi ke orang tua dan siswa
        $pelanggaran = Pelanggaran::find($request->pelanggaran_id);
        $siswa = $pelanggaran->siswa;
        $orangTua = \App\Models\OrangTua::where('siswa_id', $siswa->siswa_id)->get();
        
        foreach ($orangTua as $ot) {
            if ($ot->user_id) {
                \App\Models\Notifikasi::create([
                    'user_id' => $ot->user_id,
                    'judul' => 'Sanksi Baru',
                    'pesan' => 'Anak Anda (' . $siswa->nama_siswa . ') mendapat sanksi: ' . $request->jenis_sanksi . ' dari tanggal ' . date('d/m/Y', strtotime($request->tanggal_mulai)) . ' sampai ' . date('d/m/Y', strtotime($request->tanggal_selesai)),
                    'tipe' => 'sanksi',
                    'referensi_id' => $sanksi->sanksi_id,
                ]);
            }
        }
        
        if ($siswa->user_id) {
            \App\Models\Notifikasi::create([
                'user_id' => $siswa->user_id,
                'judul' => 'Sanksi Baru',
                'pesan' => 'Anda mendapat sanksi: ' . $request->jenis_sanksi . ' dari tanggal ' . date('d/m/Y', strtotime($request->tanggal_mulai)) . ' sampai ' . date('d/m/Y', strtotime($request->tanggal_selesai)),
                'tipe' => 'sanksi',
                'referensi_id' => $sanksi->sanksi_id,
            ]);
        }

        return redirect()->route('sanksi.index')->with('success', 'Sanksi berhasil dibuat dan notifikasi terkirim.');
    }

    public function show(Sanksi $sanksi)
    {
        $sanksi->load([
            'pelanggaran.siswa.kelas',
            'pelanggaran.jenisPelanggaran',
            'guruPenanggungJawab'
        ]);
        
        return view('sanksi.show', compact('sanksi'));
    }

    public function edit(Sanksi $sanksi)
    {
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])->get();
        $guru = User::whereIn('level', ['guru', 'kesiswaan', 'bk'])->get();
        $jenisSanksi = \App\Models\JenisSanksi::orderBy('poin_minimal')->get();
        
        return view('sanksi.edit', compact('sanksi', 'pelanggaran', 'guru', 'jenisSanksi'));
    }

    public function update(Request $request, Sanksi $sanksi)
    {
        $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggaran,pelanggaran_id',
            'jenis_sanksi' => 'required|max:100',
            'deskripsi_sanksi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'guru_penanggung_jawab' => 'required|exists:users,user_id',
        ]);

        $sanksi->update($request->only(['pelanggaran_id', 'jenis_sanksi', 'deskripsi_sanksi', 'tanggal_mulai', 'tanggal_selesai', 'guru_penanggung_jawab']));

        return redirect()->route('sanksi.index')->with('success', 'Sanksi berhasil diupdate.');
    }

    public function destroy(Sanksi $sanksi)
    {
        $sanksi->delete();
        return redirect()->route('sanksi.index')->with('success', 'Sanksi berhasil dihapus.');
    }


}