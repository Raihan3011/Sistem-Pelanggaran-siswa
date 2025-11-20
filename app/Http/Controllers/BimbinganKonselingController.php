<?php

namespace App\Http\Controllers;

use App\Models\BimbinganKonseling;
use App\Models\Siswa;
use App\Models\User;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BimbinganKonselingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->level === 'orang_tua') {
            // Orang tua hanya melihat bimbingan anaknya
            $orangTua = \App\Models\OrangTua::where('user_id', $user->user_id)->first();
            if ($orangTua) {
                $bimbingan = BimbinganKonseling::with(['siswa.kelas', 'guruKonselor', 'tahunAjaran'])
                    ->where('siswa_id', $orangTua->siswa_id)
                    ->get();
            } else {
                $bimbingan = collect();
            }
        } elseif ($user->level === 'bk') {
            // Guru BK hanya melihat bimbingan yang ditanganinya
            $bimbingan = BimbinganKonseling::with(['siswa.kelas', 'tahunAjaran'])
                ->where('guru_konselor', $user->user_id)
                ->get();
        } else {
            // Admin/Kesiswaan melihat semua bimbingan
            $bimbingan = BimbinganKonseling::with(['siswa.kelas', 'guruKonselor', 'tahunAjaran'])
                ->get();
        }
            
        return view('bimbingan-konseling.index', compact('bimbingan'));
    }

    public function create()
    {
        $siswa = Siswa::with('kelas')->get();
        $guruBK = User::where('level', 'bk')->where('is_active', true)->get();
        $tahunAjaran = TahunAjaran::where('status_aktif', true)->first();
        
        return view('bimbingan-konseling.create', compact('siswa', 'guruBK', 'tahunAjaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,siswa_id',
            'guru_konselor' => 'required|exists:users,user_id',
            'jenis_layanan' => 'required|in:Konseling Individual,Konseling Kelompok,Bimbingan Klasikal,Lainnya',
            'topik' => 'required|max:200',
            'keluhan_masalah' => 'required',
            'tanggal_konseling' => 'required|date',
        ]);

        $tahunAjaran = TahunAjaran::where('status_aktif', true)->first();

        BimbinganKonseling::create([
            'siswa_id' => $request->siswa_id,
            'guru_konselor' => $request->guru_konselor,
            'tahun_ajaran_id' => $tahunAjaran ? $tahunAjaran->id_tahun_ajaran : null,
            'jenis_layanan' => $request->jenis_layanan,
            'topik' => $request->topik,
            'keluhan_masalah' => $request->keluhan_masalah,
            'tindakan_solusi' => $request->tindakan_solusi,
            'status' => 'Pending',
            'tanggal_konseling' => $request->tanggal_konseling,
        ]);

        return redirect()->route('bimbingan-konseling.index')->with('success', 'Data bimbingan konseling berhasil ditambahkan.');
    }

    public function show($id)
    {
        $bimbinganKonseling = BimbinganKonseling::with([
            'siswa.kelas.waliKelas',
            'guruKonselor',
            'tahunAjaran'
        ])->findOrFail($id);
        
        return view('bimbingan-konseling.show', compact('bimbinganKonseling'));
    }

    public function edit($id)
    {
        $bimbinganKonseling = BimbinganKonseling::findOrFail($id);
        
        if (!$bimbinganKonseling->bisaDiupdate()) {
            return redirect()->route('bimbingan-konseling.index')->with('error', 'Bimbingan yang sudah selesai tidak dapat diubah.');
        }

        $siswa = Siswa::with('kelas')->get();
        $guruBK = User::where('level', 'bk')->where('is_active', true)->get();
        $tahunAjaran = TahunAjaran::all();
        
        return view('bimbingan-konseling.edit', compact('bimbinganKonseling', 'siswa', 'guruBK', 'tahunAjaran'));
    }

    public function update(Request $request, $id)
    {
        $bimbinganKonseling = BimbinganKonseling::findOrFail($id);
        
        if (!$bimbinganKonseling->bisaDiupdate()) {
            return redirect()->route('bimbingan-konseling.index')->with('error', 'Bimbingan yang sudah selesai tidak dapat diubah.');
        }

        $request->validate([
            'siswa_id' => 'required|exists:siswa,siswa_id',
            'guru_konselor' => 'required|exists:users,user_id',
            'jenis_layanan' => 'required|in:Konseling Individual,Konseling Kelompok,Bimbingan Klasikal,Lainnya',
            'topik' => 'required|max:200',
            'keluhan_masalah' => 'required',
            'tanggal_konseling' => 'required|date',
        ]);

        $bimbinganKonseling->update($request->all());

        return redirect()->route('bimbingan-konseling.index')->with('success', 'Data bimbingan konseling berhasil diupdate.');
    }

    public function destroy($id)
    {
        $bimbinganKonseling = BimbinganKonseling::findOrFail($id);
        
        if (!$bimbinganKonseling->bisaDiupdate()) {
            return redirect()->route('bimbingan-konseling.index')->with('error', 'Bimbingan yang sudah selesai tidak dapat dihapus.');
        }

        $bimbinganKonseling->delete();
        return redirect()->route('bimbingan-konseling.index')->with('success', 'Data bimbingan konseling berhasil dihapus.');
    }

    public function mulai(BimbinganKonseling $bimbinganKonseling)
    {
        if ($bimbinganKonseling->mulaiKonseling()) {
            return redirect()->route('bimbingan-konseling.show', $bimbinganKonseling)->with('success', 'Konseling telah dimulai.');
        }
        
        return redirect()->route('bimbingan-konseling.show', $bimbinganKonseling)->with('error', 'Tidak dapat memulai konseling.');
    }

    public function selesaikan(BimbinganKonseling $bimbinganKonseling, Request $request)
    {
        $request->validate([
            'tindakan_solusi' => 'required',
        ]);

        $bimbinganKonseling->selesaikanKonseling($request->tindakan_solusi);

        return redirect()->route('bimbingan-konseling.show', $bimbinganKonseling)->with('success', 'Konseling telah diselesaikan.');
    }

    public function tindakLanjut(BimbinganKonseling $bimbinganKonseling, Request $request)
    {
        $request->validate([
            'catatan_tambahan' => 'required',
        ]);

        $bimbinganKonseling->butuhkanTindakLanjut($request->catatan_tambahan);

        return redirect()->route('bimbingan-konseling.show', $bimbinganKonseling)->with('success', 'Konseling memerlukan tindak lanjut.');
    }

    public function laporan()
    {
        $bimbingan = BimbinganKonseling::with(['siswa.kelas', 'guruKonselor'])
            ->get();
            
        $statistik = [
            'total' => $bimbingan->count(),
            'pending' => $bimbingan->where('status', 'Pending')->count(),
            'proses' => $bimbingan->where('status', 'Proses')->count(),
            'selesai' => $bimbingan->where('status', 'Selesai')->count(),
            'tindak_lanjut' => $bimbingan->where('status', 'Tindak Lanjut')->count(),
        ];

        return view('bimbingan-konseling.laporan', compact('bimbingan', 'statistik'));
    }
}