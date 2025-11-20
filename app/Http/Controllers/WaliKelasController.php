<?php

namespace App\Http\Controllers;

use App\Models\WaliKelas;
use App\Models\Kelas;
use Illuminate\Http\Request;

class WaliKelasController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = auth()->user();
            
            // Hanya admin yang bisa create, store, edit, update, destroy, assignKelas
            if (in_array($request->route()->getActionMethod(), ['create', 'store', 'edit', 'update', 'destroy', 'assignKelas'])) {
                if ($user->level !== 'admin') {
                    abort(403, 'Hanya admin yang dapat mengelola data wali kelas.');
                }
            }
            
            return $next($request);
        });
    }

    public function index()
    {
        $waliKelas = WaliKelas::with(['user'])->orderBy('nama_guru')->get();
        
        // Manually load kelas for each wali kelas
        foreach ($waliKelas as $wk) {
            if ($wk->user_id) {
                $wk->kelas_diampu = Kelas::where('wali_kelas_id', $wk->user_id)->first();
            }
        }
        
        return view('wali-kelas.index', compact('waliKelas'));
    }

    public function create()
    {
        $kelas = \App\Models\Kelas::with('waliKelas')->orderBy('tingkat')->orderBy('jurusan')->orderBy('rombel')->get();
        $users = \App\Models\User::whereIn('level', ['guru', 'wali_kelas'])
            ->whereNotIn('user_id', function($query) {
                $query->select('user_id')->from('wali_kelas')->whereNotNull('user_id');
            })
            ->get();
        return view('wali-kelas.create', compact('kelas', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'nip' => 'required|unique:wali_kelas,nip|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'bidang_studi' => 'required|max:50',
            'email' => 'required|email|unique:wali_kelas,email',
            'no_telp' => 'nullable|max:15',
            'kelas_id' => 'required|exists:kelas,kelas_id',
        ]);

        $user = \App\Models\User::find($request->user_id);
        $user->update(['level' => 'wali_kelas']);

        $waliKelas = WaliKelas::create(array_merge(
            $request->except('kelas_id'),
            [
                'user_id' => $user->user_id,
                'nama_guru' => $user->nama_lengkap
            ]
        ));

        if ($request->kelas_id) {
            \App\Models\Kelas::where('kelas_id', $request->kelas_id)
                ->update(['wali_kelas_id' => $user->user_id]);
        }

        $message = $request->user_id ? 
            'Wali kelas berhasil didaftarkan dengan akun: ' . $user->username :
            'Wali kelas dan akun berhasil dibuat. Username: ' . $user->username . ', Password: password123';
        
        return redirect()->route('wali-kelas.index')->with('success', $message);
    }

    public function show(WaliKelas $waliKela)
    {
        $waliKela->load('kelas.siswa');
        return view('wali-kelas.show', compact('waliKela'));
    }

    public function edit(WaliKelas $waliKela)
    {
        return view('wali-kelas.edit', compact('waliKela'));
    }

    public function update(Request $request, WaliKelas $waliKela)
    {
        $request->validate([
            'nip' => 'required|max:20|unique:wali_kelas,nip,' . $waliKela->wali_kelas_id . ',wali_kelas_id',
            'nama_guru' => 'required|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'bidang_studi' => 'required|max:50',
            'email' => 'required|email|unique:wali_kelas,email,' . $waliKela->wali_kelas_id . ',wali_kelas_id',
            'no_telp' => 'nullable|max:15',
            'status' => 'required|in:Aktif,Non-Aktif',
        ]);

        $waliKela->update($request->all());

        return redirect()->route('wali-kelas.index')->with('success', 'Wali kelas berhasil diupdate.');
    }

    public function destroy(WaliKelas $waliKela)
    {
        // Cek apakah wali kelas masih memiliki kelas
        $hasKelas = Kelas::where('wali_kelas_id', $waliKela->user_id)->exists();
        if ($hasKelas) {
            return redirect()->route('wali-kelas.index')->with('error', 'Wali kelas tidak dapat dihapus karena masih memiliki kelas.');
        }

        // Hapus dari tabel kelas terlebih dahulu (set null)
        Kelas::where('wali_kelas_id', $waliKela->user_id)->update(['wali_kelas_id' => null]);
        
        // Hapus data wali kelas
        $waliKela->delete();
        
        return redirect()->route('wali-kelas.index')->with('success', 'Wali kelas berhasil dihapus.');
    }

    public function assignKelas(Request $request, $wali_kelas)
    {
        $waliKela = WaliKelas::findOrFail($wali_kelas);
        
        $request->validate([
            'kelas_id' => 'required|exists:kelas,kelas_id',
        ]);

        // Pastikan wali kelas memiliki user_id
        if (!$waliKela->user_id) {
            return redirect()->route('wali-kelas.index')->with('error', 'Wali kelas tidak memiliki akun user yang terhubung.');
        }

        // Hapus assignment kelas lama jika ada
        Kelas::where('wali_kelas_id', $waliKela->user_id)
            ->update(['wali_kelas_id' => null]);

        // Assign kelas baru
        $updated = Kelas::where('kelas_id', $request->kelas_id)
            ->update(['wali_kelas_id' => $waliKela->user_id]);

        if ($updated) {
            return redirect()->route('wali-kelas.index')->with('success', 'Kelas berhasil di-input ke wali kelas.');
        } else {
            return redirect()->route('wali-kelas.index')->with('error', 'Gagal meng-input kelas.');
        }
    }
}
