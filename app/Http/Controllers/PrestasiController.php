<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->level == 'orang_tua') {
            $orangTua = \App\Models\OrangTua::where('user_id', $user->user_id)->first();
            if ($orangTua) {
                $prestasi = Prestasi::with(['siswa.kelas', 'guruPencatat'])
                    ->where('siswa_id', $orangTua->siswa_id)
                    ->orderBy('tanggal', 'desc')
                    ->get();
            } else {
                $prestasi = collect();
            }
        } elseif ($user->level == 'siswa') {
            $siswa = \App\Models\Siswa::where('user_id', $user->user_id)->first();
            if ($siswa) {
                $prestasi = Prestasi::with(['siswa.kelas', 'guruPencatat'])
                    ->where('siswa_id', $siswa->siswa_id)
                    ->orderBy('tanggal', 'desc')
                    ->get();
            } else {
                $prestasi = collect();
            }
        } else {
            $prestasi = Prestasi::with(['siswa.kelas', 'guruPencatat'])
                ->orderBy('tanggal', 'desc')
                ->get();
        }
            
        return view('prestasi.index', compact('prestasi'));
    }

    public function create()
    {
        $siswa = Siswa::with('kelas')->get();
        $jenisPrestasi = \App\Models\JenisPrestasi::all();
        return view('prestasi.create', compact('siswa', 'jenisPrestasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,siswa_id',
            'jenis_prestasi_id' => 'required|exists:jenis_prestasi,jenis_prestasi_id',
            'penghargaan' => 'required|max:200',
            'tingkat' => 'required|in:Sekolah,Kecamatan,Kota,Provinsi,Nasional,Internasional',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable',
            'bukti_dokumen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti_dokumen')) {
            $buktiPath = $request->file('bukti_dokumen')->store('bukti-prestasi', 'public');
        }

        $tahunAjaran = \App\Models\TahunAjaran::where('status_aktif', true)->first();

        $pointMap = [
            'Sekolah' => 10,
            'Kecamatan' => 20,
            'Kota' => 30,
            'Provinsi' => 50,
            'Nasional' => 75,
            'Internasional' => 100
        ];

        $prestasi = Prestasi::create([
            'siswa_id' => $request->siswa_id,
            'jenis_prestasi_id' => $request->jenis_prestasi_id,
            'penghargaan' => $request->penghargaan,
            'tingkat' => $request->tingkat,
            'point' => $pointMap[$request->tingkat] ?? 10,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'bukti_dokumen' => $buktiPath,
            'guru_pencatat' => Auth::id(),
            'status_verifikasi' => 'Pending',
            'tahun_ajaran_id' => $tahunAjaran->tahun_ajaran_id,
        ]);
        
        // Kirim notifikasi ke orang tua dan siswa
        $siswa = Siswa::find($request->siswa_id);
        $orangTua = \App\Models\OrangTua::where('siswa_id', $siswa->siswa_id)->get();
        
        foreach ($orangTua as $ot) {
            if ($ot->user_id) {
                \App\Models\Notifikasi::create([
                    'user_id' => $ot->user_id,
                    'judul' => 'Prestasi Baru',
                    'pesan' => 'Selamat! Anak Anda (' . $siswa->nama_siswa . ') meraih prestasi: ' . $request->penghargaan . ' tingkat ' . $request->tingkat,
                    'tipe' => 'prestasi',
                    'referensi_id' => $prestasi->prestasi_id,
                ]);
            }
        }
        
        if ($siswa->user_id) {
            \App\Models\Notifikasi::create([
                'user_id' => $siswa->user_id,
                'judul' => 'Prestasi Baru',
                'pesan' => 'Selamat! Anda meraih prestasi: ' . $request->penghargaan . ' tingkat ' . $request->tingkat,
                'tipe' => 'prestasi',
                'referensi_id' => $prestasi->prestasi_id,
            ]);
        }

        return redirect()->route('prestasi.index')->with('success', 'Prestasi berhasil ditambahkan dan notifikasi terkirim.');
    }

    public function show(Prestasi $prestasi)
    {
        $prestasi->load(['siswa.kelas', 'guruPencatat']);
        return view('prestasi.show', compact('prestasi'));
    }

    public function edit(Prestasi $prestasi)
    {
        $siswa = Siswa::with('kelas')->get();
        $jenisPrestasi = \App\Models\JenisPrestasi::all();
        return view('prestasi.edit', compact('prestasi', 'siswa', 'jenisPrestasi'));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,siswa_id',
            'penghargaan' => 'required|max:200',
            'tingkat' => 'required|in:Sekolah,Kecamatan,Kota,Provinsi,Nasional,Internasional',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable',
            'bukti_dokumen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $buktiPath = $prestasi->bukti_dokumen;
        if ($request->hasFile('bukti_dokumen')) {
            if ($prestasi->bukti_dokumen) {
                Storage::disk('public')->delete($prestasi->bukti_dokumen);
            }
            $buktiPath = $request->file('bukti_dokumen')->store('bukti-prestasi', 'public');
        }

        $prestasi->update([
            'siswa_id' => $request->siswa_id,
            'penghargaan' => $request->penghargaan,
            'tingkat' => $request->tingkat,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'bukti_dokumen' => $buktiPath,
        ]);

        return redirect()->route('prestasi.index')->with('success', 'Prestasi berhasil diupdate.');
    }

    public function destroy(Prestasi $prestasi)
    {
        if ($prestasi->bukti_dokumen) {
            Storage::disk('public')->delete($prestasi->bukti_dokumen);
        }

        $prestasi->delete();
        return redirect()->route('prestasi.index')->with('success', 'Prestasi berhasil dihapus.');
    }
}
