<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SiswaController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->level == 'orang_tua') {
            $orangTua = \App\Models\OrangTua::where('user_id', $user->user_id)->first();
            if ($orangTua) {
                $siswa = Siswa::with(['kelas', 'user'])
                    ->where('siswa_id', $orangTua->siswa_id)
                    ->get();
            } else {
                $siswa = collect();
            }
        } elseif ($user->level == 'wali_kelas') {
            $kelas = Kelas::where('wali_kelas_id', $user->user_id)->first();
            if ($kelas) {
                $siswa = Siswa::with(['kelas', 'user'])
                    ->where('kelas_id', $kelas->kelas_id)
                    ->orderBy('nama_siswa')
                    ->get();
            } else {
                $siswa = collect();
            }
        } else {
            // Admin, kesiswaan, guru, bk melihat semua siswa
            $siswa = Siswa::with(['kelas', 'user'])
                ->orderBy('nama_siswa')
                ->get();
        }
            
        return view('siswa.index', compact('siswa'));
    }

    public function create()
    {
        $user = auth()->user();
        
        if (!in_array($user->level, ['admin', 'kesiswaan', 'wali_kelas', 'guru'])) {
            return redirect()->route('siswa.index')->with('error', 'Anda tidak memiliki akses untuk menambah data siswa.');
        }
        
        if ($user->level == 'wali_kelas') {
            // Wali kelas hanya bisa pilih kelasnya sendiri
            $kelas = Kelas::where('wali_kelas_id', $user->user_id)->get();
        } else {
            $kelas = Kelas::all();
        }
        
        return view('siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        if (!in_array($user->level, ['admin', 'kesiswaan', 'wali_kelas', 'guru'])) {
            return redirect()->route('siswa.index')->with('error', 'Anda tidak memiliki akses untuk menambah data siswa.');
        }
        
        // Validasi wali kelas hanya bisa input siswa ke kelasnya
        if ($user->level == 'wali_kelas') {
            $kelas = Kelas::where('wali_kelas_id', $user->user_id)->first();
            if (!$kelas || $request->kelas_id != $kelas->kelas_id) {
                return redirect()->back()->with('error', 'Anda hanya bisa menambah siswa ke kelas Anda sendiri.')->withInput();
            }
        }
        
        $request->validate([
            'nis' => 'required|unique:siswa,nis|max:20',
            'nisn' => 'required|unique:siswa,nisn|max:20',
            'nama_siswa' => 'required|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|max:50',
            'alamat' => 'required',
            'no_telp' => 'nullable|max:15',
            'kelas_id' => 'required|exists:kelas,kelas_id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        


        // Handle foto upload
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto-siswa', 'public');
        }

        // Create siswa langsung
        $siswa = Siswa::create([
            'user_id' => null,
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'nama_siswa' => $request->nama_siswa,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'kelas_id' => $request->kelas_id,
            'foto' => $fotoPath,
        ]);
        
        // Jika request AJAX, return JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'siswa' => $siswa->load('kelas'),
                'message' => 'Siswa berhasil ditambahkan'
            ]);
        }
        
        return redirect()->route('siswa.index')->with('success', 'Data siswa dan akun user berhasil dibuat.');
    }
    


    public function show(Siswa $siswa)
    {
        $siswa->load([
            'kelas',
            'pelanggaran.jenisPelanggaran'
        ]);

        return view('siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        $user = auth()->user();
        
        if (!in_array($user->level, ['admin', 'kesiswaan', 'wali_kelas', 'guru'])) {
            return redirect()->route('siswa.index')->with('error', 'Anda tidak memiliki akses untuk mengedit data siswa.');
        }
        
        // Validasi wali kelas hanya bisa edit siswa di kelasnya
        if ($user->level == 'wali_kelas') {
            $kelasWali = Kelas::where('wali_kelas_id', $user->user_id)->first();
            if (!$kelasWali || $siswa->kelas_id != $kelasWali->kelas_id) {
                abort(403, 'Anda tidak memiliki akses untuk mengedit siswa ini.');
            }
            $kelas = Kelas::where('kelas_id', $kelasWali->kelas_id)->get();
        } else {
            $kelas = Kelas::all();
        }
        
        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $user = auth()->user();
        
        if (!in_array($user->level, ['admin', 'kesiswaan', 'wali_kelas', 'guru'])) {
            return redirect()->route('siswa.index')->with('error', 'Anda tidak memiliki akses untuk mengedit data siswa.');
        }
        
        // Validasi wali kelas hanya bisa update siswa di kelasnya
        if ($user->level == 'wali_kelas') {
            $kelasWali = Kelas::where('wali_kelas_id', $user->user_id)->first();
            if (!$kelasWali || $siswa->kelas_id != $kelasWali->kelas_id || $request->kelas_id != $kelasWali->kelas_id) {
                return redirect()->back()->with('error', 'Anda hanya bisa mengedit siswa di kelas Anda sendiri.')->withInput();
            }
        }
        
        $request->validate([
            'nis' => 'required|max:20|unique:siswa,nis,' . $siswa->siswa_id . ',siswa_id',
            'nisn' => 'required|max:20|unique:siswa,nisn,' . $siswa->siswa_id . ',siswa_id',
            'nama_siswa' => 'required|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|max:50',
            'alamat' => 'required',
            'no_telp' => 'nullable|max:15',
            'kelas_id' => 'required|exists:kelas,kelas_id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle foto upload
        $fotoPath = $siswa->foto;
        if ($request->hasFile('foto')) {
            // Delete old foto if exists
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $fotoPath = $request->file('foto')->store('foto-siswa', 'public');
        }

        // Tidak update user account karena tidak ada

        $siswa->update([
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'nama_siswa' => $request->nama_siswa,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'kelas_id' => $request->kelas_id,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil diupdate.');
    }

    public function destroy(Siswa $siswa)
    {
        $user = auth()->user();
        
        if (!in_array($user->level, ['admin', 'kesiswaan', 'wali_kelas', 'guru'])) {
            return redirect()->route('siswa.index')->with('error', 'Anda tidak memiliki akses untuk menghapus data siswa.');
        }
        
        // Validasi wali kelas hanya bisa hapus siswa di kelasnya
        if ($user->level == 'wali_kelas') {
            $kelasWali = Kelas::where('wali_kelas_id', $user->user_id)->first();
            if (!$kelasWali || $siswa->kelas_id != $kelasWali->kelas_id) {
                abort(403, 'Anda tidak memiliki akses untuk menghapus siswa ini.');
            }
        }
        
        // Delete foto if exists
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->delete();
        
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Siswa berhasil dihapus']);
        }
        
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }

    public function statistik(Siswa $siswa)
    {
        return view('siswa.statistik', compact('siswa'));
    }
    

}