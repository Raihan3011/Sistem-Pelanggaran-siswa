<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $kelas = \App\Models\Kelas::whereNull('wali_kelas_id')->orWhere('wali_kelas_id', '')->get();
        return view('users.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'nama_lengkap' => 'required',
            'level' => 'required|in:admin,kesiswaan,bk,wali_kelas,guru,orang_tua,siswa',
            'kelas_id' => 'required_if:level,wali_kelas|nullable|exists:kelas,kelas_id',
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama_lengkap' => $request->nama_lengkap,
            'level' => $request->level,
            'is_active' => true,
        ]);
        
        // Jika level wali_kelas, assign ke kelas
        if ($request->level == 'wali_kelas' && $request->kelas_id) {
            \App\Models\Kelas::where('kelas_id', $request->kelas_id)->update(['wali_kelas_id' => $user->user_id]);
        }
        
        // Jika level siswa, buat data siswa dengan data minimal
        if ($request->level == 'siswa') {
            try {
                // Pastikan ada kelas, jika tidak buat kelas default
                $kelasDefault = \App\Models\Kelas::first();
                if (!$kelasDefault) {
                    $kelasDefault = \App\Models\Kelas::create([
                        'nama_kelas' => 'Kelas Default',
                        'jurusan' => 'PPLG',
                        'kapasitas' => 40
                    ]);
                }
                
                $siswa = \App\Models\Siswa::create([
                    'user_id' => $user->user_id,
                    'nis' => 'AUTO-' . str_pad($user->user_id, 6, '0', STR_PAD_LEFT),
                    'nisn' => 'AUTO-' . str_pad($user->user_id, 10, '0', STR_PAD_LEFT),
                    'nama_siswa' => $request->nama_lengkap,
                    'jenis_kelamin' => 'L',
                    'tanggal_lahir' => '2000-01-01',
                    'tempat_lahir' => '-',
                    'alamat' => '-',
                    'kelas_id' => $kelasDefault->kelas_id,
                ]);
                
                \Log::info('Siswa berhasil dibuat: ' . $siswa->siswa_id . ' untuk user: ' . $user->user_id);
            } catch (\Exception $e) {
                \Log::error('Error membuat siswa: ' . $e->getMessage());
            }
        }

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $kelas = \App\Models\Kelas::whereNull('wali_kelas_id')->orWhere('wali_kelas_id', '')->orWhere('wali_kelas_id', $user->user_id)->get();
        $kelasUser = \App\Models\Kelas::where('wali_kelas_id', $user->user_id)->first();
        return view('users.edit', compact('user', 'kelas', 'kelasUser'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $user->user_id . ',user_id',
            'password' => 'nullable|min:6',
            'nama_lengkap' => 'required',
            'level' => 'required|in:admin,kesiswaan,bk,wali_kelas,guru,orang_tua,siswa',
            'kelas_id' => 'required_if:level,wali_kelas|nullable|exists:kelas,kelas_id',
        ]);

        $data = [
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'level' => $request->level,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        
        // Update kelas assignment
        if ($request->level == 'wali_kelas' && $request->kelas_id) {
            // Hapus assignment lama
            \App\Models\Kelas::where('wali_kelas_id', $user->user_id)->update(['wali_kelas_id' => null]);
            // Set assignment baru
            \App\Models\Kelas::where('kelas_id', $request->kelas_id)->update(['wali_kelas_id' => $user->user_id]);
        } elseif ($request->level != 'wali_kelas') {
            // Jika level diubah dari wali_kelas, hapus assignment
            \App\Models\Kelas::where('wali_kelas_id', $user->user_id)->update(['wali_kelas_id' => null]);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(Request $request, User $user)
    {
        // Cek apakah user masih menjadi wali kelas
        $kelasCount = \App\Models\Kelas::where('wali_kelas_id', $user->user_id)->count();
        
        // Cek data terkait lainnya
        $pelanggaranCount = \DB::table('pelanggaran')->where('guru_pencatat', $user->user_id)->count();
        $pelanggaranVerifikatorCount = \DB::table('pelanggaran')->where('guru_verifikator', $user->user_id)->count();
        $sanksiCount = \DB::table('sanksi')->where('guru_penanggung_jawab', $user->user_id)->count();
        $waliKelasCount = \App\Models\WaliKelas::where('user_id', $user->user_id)->count();
        
        if ($kelasCount > 0 || $pelanggaranCount > 0 || $pelanggaranVerifikatorCount > 0 || $sanksiCount > 0 || $waliKelasCount > 0) {
            if ($request->has('force')) {
                $adminUser = User::where('level', 'admin')->first();
                if ($adminUser) {
                    // Hapus referensi dari tabel kelas
                    \App\Models\Kelas::where('wali_kelas_id', $user->user_id)->update(['wali_kelas_id' => null]);
                    
                    // Transfer data pelanggaran ke admin
                    \DB::table('pelanggaran')->where('guru_pencatat', $user->user_id)->update(['guru_pencatat' => $adminUser->user_id]);
                    \DB::table('pelanggaran')->where('guru_verifikator', $user->user_id)->whereNotNull('guru_verifikator')->update(['guru_verifikator' => $adminUser->user_id]);
                    \DB::table('sanksi')->where('guru_penanggung_jawab', $user->user_id)->update(['guru_penanggung_jawab' => $adminUser->user_id]);
                    
                    // Hapus data wali kelas
                    \App\Models\WaliKelas::where('user_id', $user->user_id)->delete();
                } else {
                    return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus user karena tidak ada admin untuk transfer data.');
                }
            } else {
                $errorMsg = 'User tidak dapat dihapus karena masih memiliki:';
                if ($kelasCount > 0) $errorMsg .= ' ' . $kelasCount . ' kelas,';
                if ($pelanggaranCount > 0) $errorMsg .= ' ' . $pelanggaranCount . ' pelanggaran,';
                if ($sanksiCount > 0) $errorMsg .= ' ' . $sanksiCount . ' sanksi,';
                if ($waliKelasCount > 0) $errorMsg .= ' data wali kelas,';
                $errorMsg = rtrim($errorMsg, ',') . ' terkait.';
                
                return redirect()->route('users.index')->with('error', $errorMsg);
            }
        }
        
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus dan data terkait telah ditransfer ke admin.');
    }
}
