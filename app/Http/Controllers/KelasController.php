<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = auth()->user();
            
            // Hanya admin yang bisa create, edit, update, delete
            if (in_array($request->route()->getActionMethod(), ['create', 'store', 'edit', 'update', 'destroy'])) {
                if ($user->level !== 'admin') {
                    abort(403, 'Hanya admin yang dapat mengelola data kelas.');
                }
            }
            
            return $next($request);
        });
    }

    public function index()
    {
        $kelas = Kelas::with(['waliKelas'])
            ->withCount('siswa')
            ->orderBy('nama_kelas')
            ->get();
            
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        $guru = User::where('level', 'wali_kelas')->get();
        return view('kelas.create', compact('guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'jurusan' => 'required|in:PPLG,AKT,BDP,DKV,ANM',
            'kapasitas' => 'required|integer|min:1|max:50',
            'wali_kelas_id' => 'nullable|exists:users,user_id',
        ]);

        Kelas::create($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dibuat.');
    }

    public function show(Kelas $kela)
    {
        $kela->load(['waliKelas', 'siswa']);
        return view('kelas.show', compact('kela'));
    }

    public function edit(Kelas $kela)
    {
        $guru = User::where('level', 'wali_kelas')->get();
        return view('kelas.edit', compact('kela', 'guru'));
    }

    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'jurusan' => 'required|in:PPLG,AKT,BDP,DKV,ANM',
            'kapasitas' => 'required|integer|min:1|max:50',
            'wali_kelas_id' => 'nullable|exists:users,user_id',
        ]);

        $kela->update($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diupdate.');
    }

    public function destroy(Kelas $kela)
    {
        if ($kela->siswa()->count() > 0) {
            return redirect()->route('kelas.index')->with('error', 'Tidak dapat menghapus kelas yang masih memiliki siswa.');
        }

        $kela->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}