<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\JenisPelanggaran;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PelanggaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orangTua = \App\Models\OrangTua::where('user_id', $user->user_id)->first();
        $siswa = \App\Models\Siswa::where('user_id', $user->user_id)->first();
        
        if ($orangTua) {
            // Orang tua hanya melihat pelanggaran anaknya
            $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])
                ->where('siswa_id', $orangTua->siswa_id)
                ->orderBy('tanggal', 'desc')
                ->get();
        } elseif ($siswa) {
            // Siswa hanya melihat pelanggaran dirinya sendiri
            $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])
                ->where('siswa_id', $siswa->siswa_id)
                ->orderBy('tanggal', 'desc')
                ->get();
        } elseif ($user->level == 'wali_kelas') {
            // Wali kelas hanya melihat pelanggaran siswa di kelasnya
            $kelas = \App\Models\Kelas::where('wali_kelas_id', $user->user_id)->first();
            if ($kelas) {
                $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])
                    ->whereHas('siswa', function($query) use ($kelas) {
                        $query->where('kelas_id', $kelas->kelas_id);
                    })
                    ->orderBy('tanggal', 'desc')
                    ->get();
            } else {
                $pelanggaran = collect();
            }
        } else {
            // Admin/Kesiswaan/Guru/BK melihat semua pelanggaran
            $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat', 'guruVerifikator'])
                ->orderBy('tanggal', 'desc')
                ->get();
        }
            
        return view('pelanggaran.index', compact('pelanggaran'));
    }

    public function create()
    {
        $user = Auth::user();
        
        if ($user->level == 'wali_kelas') {
            $kelas = \App\Models\Kelas::where('wali_kelas_id', $user->user_id)->first();
            if ($kelas) {
                $siswa = User::where('level', 'siswa')
                    ->with(['siswa.kelas'])
                    ->whereHas('siswa', function($q) use ($kelas) {
                        $q->where('kelas_id', $kelas->kelas_id);
                    })
                    ->orderBy('nama_lengkap')
                    ->get();
            } else {
                $siswa = collect();
            }
        } else {
            $siswa = Siswa::with('kelas')->orderBy('nama_siswa')->get();
        }
        
        $jenisPelanggaran = JenisPelanggaran::all();
        $tahunAjaran = TahunAjaran::where('status_aktif', true)->first();
        
        return view('pelanggaran.create', compact('siswa', 'jenisPelanggaran', 'tahunAjaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,siswa_id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,jenis_pelanggaran_id',
            'point' => 'required|integer|min:1|max:100',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $jenisPelanggaran = JenisPelanggaran::find($request->jenis_pelanggaran_id);
        $tahunAjaran = TahunAjaran::where('status_aktif', true)->first();

        if (!$tahunAjaran) {
            return back()->with('error', 'Tidak ada tahun ajaran aktif. Hubungi administrator.')->withInput();
        }

        // Validasi point sesuai dengan range jenis pelanggaran
        $pointPelanggaran = $request->point;
        if ($pointPelanggaran < $jenisPelanggaran->poin_minimal || $pointPelanggaran > $jenisPelanggaran->poin_maksimal) {
            return back()->with('error', 'Point harus berada dalam range ' . $jenisPelanggaran->poin_minimal . ' - ' . $jenisPelanggaran->poin_maksimal . ' untuk jenis pelanggaran ini.')->withInput();
        }

        // Handle bukti foto upload
        $buktiFotoPath = null;
        if ($request->hasFile('bukti_foto')) {
            $buktiFotoPath = $request->file('bukti_foto')->store('bukti-pelanggaran', 'public');
        }
        
        $pelanggaran = Pelanggaran::create([
            'siswa_id' => $request->siswa_id,
            'guru_pencatat' => Auth::id(),
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'tahun_ajaran_id' => $tahunAjaran->tahun_ajaran_id,
            'point' => $pointPelanggaran,
            'keterangan' => $request->keterangan,
            'bukti_foto' => $buktiFotoPath,
            'status_verifikasi' => 'Pending',
            'tanggal' => $request->tanggal,
        ]);
        
        // Kirim notifikasi ke orang tua dan siswa
        $siswa = Siswa::find($request->siswa_id);
        $orangTua = \App\Models\OrangTua::where('siswa_id', $siswa->siswa_id)->get();
        
        foreach ($orangTua as $ot) {
            if ($ot->user_id) {
                \App\Models\Notifikasi::create([
                    'user_id' => $ot->user_id,
                    'judul' => 'Pelanggaran Baru',
                    'pesan' => 'Anak Anda (' . $siswa->nama_siswa . ') melakukan pelanggaran: ' . $jenisPelanggaran->nama_pelanggaran . ' dengan poin ' . $jenisPelanggaran->point,
                    'tipe' => 'pelanggaran',
                    'referensi_id' => $pelanggaran->pelanggaran_id,
                ]);
            }
        }
        
        if ($siswa->user_id) {
            \App\Models\Notifikasi::create([
                'user_id' => $siswa->user_id,
                'judul' => 'Pelanggaran Baru',
                'pesan' => 'Anda melakukan pelanggaran: ' . $jenisPelanggaran->nama_pelanggaran . ' dengan poin ' . $jenisPelanggaran->point,
                'tipe' => 'pelanggaran',
                'referensi_id' => $pelanggaran->pelanggaran_id,
            ]);
        }

        return redirect()->route('pelanggaran.index')->with('success', 'Pelanggaran berhasil dicatat dan notifikasi terkirim.');
    }

    public function show(Pelanggaran $pelanggaran)
    {
        $pelanggaran->load([
            'siswa.kelas',
            'jenisPelanggaran', 
            'guruPencatat',
            'guruVerifikator'
        ]);
        
        return view('pelanggaran.show', compact('pelanggaran'));
    }

    public function edit(Pelanggaran $pelanggaran)
    {
        $user = Auth::user();
        
        // Cek akses wali kelas
        if ($user->level == 'wali_kelas') {
            $kelas = \App\Models\Kelas::where('wali_kelas_id', $user->user_id)->first();
            if (!$kelas || $pelanggaran->siswa->kelas_id != $kelas->kelas_id) {
                abort(403, 'Anda tidak memiliki akses untuk mengedit pelanggaran ini.');
            }
            $siswa = Siswa::with('kelas')->where('kelas_id', $kelas->kelas_id)->get();
        } else {
            $siswa = Siswa::with('kelas')->get();
        }
        
        $jenisPelanggaran = JenisPelanggaran::all();
        
        return view('pelanggaran.edit', compact('pelanggaran', 'siswa', 'jenisPelanggaran'));
    }

    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,siswa_id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,jenis_pelanggaran_id',
            'point' => 'required|integer|min:1|max:100',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable',
            'status_verifikasi' => 'nullable|in:Pending,Terverifikasi,Ditolak',
            'catatan_verifikasi' => 'required_if:status_verifikasi,Terverifikasi',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $jenisPelanggaran = JenisPelanggaran::find($request->jenis_pelanggaran_id);

        // Validasi point sesuai dengan range jenis pelanggaran
        $pointPelanggaran = $request->point;
        if ($pointPelanggaran < $jenisPelanggaran->poin_minimal || $pointPelanggaran > $jenisPelanggaran->poin_maksimal) {
            return back()->with('error', 'Point harus berada dalam range ' . $jenisPelanggaran->poin_minimal . ' - ' . $jenisPelanggaran->poin_maksimal . ' untuk jenis pelanggaran ini.')->withInput();
        }

        // Handle bukti foto upload
        $buktiFotoPath = $pelanggaran->bukti_foto;
        if ($request->hasFile('bukti_foto')) {
            // Delete old foto if exists
            if ($pelanggaran->bukti_foto) {
                Storage::disk('public')->delete($pelanggaran->bukti_foto);
            }
            $buktiFotoPath = $request->file('bukti_foto')->store('bukti-pelanggaran', 'public');
        }
        
        $updateData = [
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'point' => $pointPelanggaran,
            'keterangan' => $request->keterangan,
            'bukti_foto' => $buktiFotoPath,
            'tanggal' => $request->tanggal,
        ];
        
        if ($request->status_verifikasi) {
            $updateData['status_verifikasi'] = $request->status_verifikasi;
            
            // Jika status berubah menjadi Terverifikasi, simpan verifikator dan alasan
            if ($request->status_verifikasi == 'Terverifikasi' && $pelanggaran->status_verifikasi != 'Terverifikasi') {
                $updateData['guru_verifikator'] = Auth::id();
                $updateData['catatan_verifikasi'] = $request->catatan_verifikasi;
            }
        }
        
        $pelanggaran->update($updateData);

        return redirect()->route('pelanggaran.index')->with('success', 'Pelanggaran berhasil diupdate.');
    }

    public function destroy(Pelanggaran $pelanggaran)
    {
        $user = Auth::user();
        
        // Cek akses wali kelas
        if ($user->level == 'wali_kelas') {
            $kelas = \App\Models\Kelas::where('wali_kelas_id', $user->user_id)->first();
            if (!$kelas || $pelanggaran->siswa->kelas_id != $kelas->kelas_id) {
                abort(403, 'Anda tidak memiliki akses untuk menghapus pelanggaran ini.');
            }
        }
        
        // Hapus sanksi terkait terlebih dahulu
        \App\Models\Sanksi::where('pelanggaran_id', $pelanggaran->pelanggaran_id)->delete();
        
        // Delete bukti foto if exists
        if ($pelanggaran->bukti_foto) {
            Storage::disk('public')->delete($pelanggaran->bukti_foto);
        }

        $pelanggaran->delete();
        return redirect()->route('pelanggaran.index')->with('success', 'Pelanggaran dan sanksi terkait berhasil dihapus.');
    }

    public function verify(Pelanggaran $pelanggaran, Request $request)
    {

        $request->validate([
            'status_verifikasi' => 'required|in:Terverifikasi,Ditolak',
            'catatan_verifikasi' => 'required_if:status_verifikasi,Ditolak',
        ]);

        $pelanggaran->update([
            'status_verifikasi' => $request->status_verifikasi,
            'guru_verifikator' => Auth::id(),
            'catatan_verifikasi' => $request->catatan_verifikasi,
        ]);

        $status = $request->status_verifikasi == 'Terverifikasi' ? 'diverifikasi' : 'ditolak';
        return redirect()->route('pelanggaran.show', $pelanggaran)->with('success', "Pelanggaran berhasil $status.");
    }

    public function verifikasiIndex()
    {
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])
            ->where('status_verifikasi', 'Pending')
            ->orderBy('tanggal', 'desc')
            ->get();
            
        return view('pelanggaran.verifikasi-index', compact('pelanggaran'));
    }

    public function laporan(Request $request)
    {
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])
            ->when($request->tanggal_mulai && $request->tanggal_selesai, function($query) use ($request) {
                return $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
            })
            ->when($request->status_verifikasi, function($query) use ($request) {
                return $query->where('status_verifikasi', $request->status_verifikasi);
            })
            ->when($request->kategori, function($query) use ($request) {
                return $query->whereHas('jenisPelanggaran', function($q) use ($request) {
                    $q->where('kategori', $request->kategori);
                });
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        $statistik = [
            'total' => $pelanggaran->count(),
            'terverifikasi' => $pelanggaran->where('status_verifikasi', 'Terverifikasi')->count(),
            'pending' => $pelanggaran->where('status_verifikasi', 'Pending')->count(),
            'ditolak' => $pelanggaran->where('status_verifikasi', 'Ditolak')->count(),
        ];

        return view('pelanggaran.laporan', compact('pelanggaran', 'statistik'));
    }
}