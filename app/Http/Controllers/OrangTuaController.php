<?php

namespace App\Http\Controllers;

use App\Models\OrangTua;
use App\Models\Siswa;
use Illuminate\Http\Request;

class OrangTuaController extends Controller
{
    public function index()
    {
        if (auth()->user()->level == 'orang_tua') {
            $currentOrangTua = OrangTua::where('user_id', auth()->id())->first();
            if ($currentOrangTua && $currentOrangTua->siswa_id) {
                // Jika orang tua, tampilkan semua data orang tua dari anak mereka (ayah, ibu, wali)
                $orangTua = OrangTua::with('siswa')
                    ->where('siswa_id', $currentOrangTua->siswa_id)
                    ->orderBy('hubungan')
                    ->get();
            } else {
                $orangTua = collect();
            }
        } elseif (auth()->user()->level == 'wali_kelas') {
            // Jika wali kelas, tampilkan data orang tua dari siswa di kelasnya
            $kelas = \App\Models\Kelas::where('wali_kelas_id', auth()->id())->first();
            if ($kelas) {
                $orangTua = OrangTua::with('siswa')
                    ->whereHas('siswa', function($query) use ($kelas) {
                        $query->where('kelas_id', $kelas->kelas_id);
                    })
                    ->orderBy('nama_orang_tua')
                    ->get();
            } else {
                // Jika wali kelas belum memiliki kelas, tampilkan pesan khusus
                $orangTua = collect();
            }
        } else {
            // Jika admin/kesiswaan, tampilkan semua data
            $orangTua = OrangTua::with('siswa')->orderBy('nama_orang_tua')->get();
        }
        
        return view('orang-tua.index', compact('orangTua'));
    }

    public function create()
    {
        $siswa = Siswa::orderBy('nama_siswa')->get();
        // Hanya tampilkan user orang_tua yang belum terhubung (siswa_id masih null)
        $users = \App\Models\User::where('level', 'orang_tua')
            ->whereHas('orangTua', function($query) {
                $query->whereNull('siswa_id');
            })
            ->orderBy('nama_lengkap')
            ->get();
        return view('orang-tua.create', compact('siswa', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'siswa_id' => 'required|exists:siswa,siswa_id',
            'hubungan' => 'required|in:Ayah,Ibu,Wali',
            'pekerjaan' => 'nullable|max:50',
            'pendidikan' => 'nullable|max:50',
            'no_telp' => 'nullable|max:15',
            'alamat' => 'required',
        ]);

        // Cek apakah sudah ada data orang tua dengan siswa_id dan hubungan yang sama
        $existing = OrangTua::where('siswa_id', $request->siswa_id)
            ->where('hubungan', $request->hubungan)
            ->first();
            
        if ($existing) {
            return back()->with('error', 'Data ' . $request->hubungan . ' untuk siswa ini sudah ada.')->withInput();
        }

        // Update data orang tua yang sudah ada dengan siswa_id
        $orangTua = OrangTua::where('user_id', $request->user_id)->first();
        if ($orangTua) {
            $orangTua->update([
                'siswa_id' => $request->siswa_id,
                'hubungan' => $request->hubungan,
                'pekerjaan' => $request->pekerjaan,
                'pendidikan' => $request->pendidikan,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
            ]);
        }

        return redirect()->route('orang-tua.index')->with('success', 'Data orang tua berhasil disambungkan.');
    }

    public function show(OrangTua $orangTua)
    {
        if (auth()->user()->level == 'orang_tua') {
            $currentOrangTua = OrangTua::where('user_id', auth()->id())->first();
            // Pastikan hanya bisa melihat data orang tua dari anak mereka
            if ($currentOrangTua && $currentOrangTua->siswa_id && $orangTua->siswa_id != $currentOrangTua->siswa_id) {
                return redirect()->route('orang-tua.index')->with('error', 'Anda hanya dapat mengakses data orang tua dari anak Anda.');
            }
        }
        
        if ($orangTua->siswa_id) {
            $orangTua->load('siswa.kelas');
        }
        return view('orang-tua.show', compact('orangTua'));
    }

    public function edit(OrangTua $orangTua)
    {
        $siswa = Siswa::orderBy('nama_siswa')->get();
        return view('orang-tua.edit', compact('orangTua', 'siswa'));
    }

    public function update(Request $request, OrangTua $orangTua)
    {
        $request->validate([
            'siswa_id' => 'nullable|exists:siswa,siswa_id',
            'hubungan' => 'required|in:Ayah,Ibu,Wali',
            'nama_orang_tua' => 'required|max:100',
            'pekerjaan' => 'nullable|max:50',
            'pendidikan' => 'nullable|max:50',
            'no_telp' => 'nullable|max:15',
            'alamat' => 'required',
        ]);

        // Cek apakah ada data lain dengan siswa_id dan hubungan yang sama (kecuali data ini)
        if ($request->siswa_id) {
            $existing = OrangTua::where('siswa_id', $request->siswa_id)
                ->where('hubungan', $request->hubungan)
                ->where('orang_tua_id', '!=', $orangTua->orang_tua_id)
                ->first();
                
            if ($existing) {
                return back()->with('error', 'Data ' . $request->hubungan . ' untuk siswa ini sudah ada.')->withInput();
            }
        }

        $orangTua->update([
            'siswa_id' => $request->siswa_id,
            'hubungan' => $request->hubungan,
            'nama_orang_tua' => $request->nama_orang_tua,
            'pekerjaan' => $request->pekerjaan,
            'pendidikan' => $request->pendidikan,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('orang-tua.index')->with('success', 'Data orang tua berhasil diupdate.');
    }

    public function destroy(OrangTua $orangTua)
    {
        $orangTua->delete();
        return redirect()->route('orang-tua.index')->with('success', 'Data orang tua berhasil dihapus.');
    }
}
