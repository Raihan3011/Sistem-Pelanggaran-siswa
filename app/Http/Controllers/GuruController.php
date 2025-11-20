<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index()
    {
        $guru = User::whereIn('level', ['guru', 'kesiswaan', 'wali_kelas'])->orderBy('nama_lengkap')->get();
        return view('guru.index', compact('guru'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|max:100',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'level' => 'required|in:guru,kesiswaan,wali_kelas',
            'nip' => 'nullable|max:50',
            'no_telepon' => 'nullable|max:20',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'level' => $request->level,
            'nip' => $request->nip,
            'no_telepon' => $request->no_telepon,
        ]);

        return redirect()->route('guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function show(User $guru)
    {
        return view('guru.show', compact('guru'));
    }

    public function edit(User $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, User $guru)
    {
        $request->validate([
            'nama_lengkap' => 'required|max:100',
            'username' => 'required|unique:users,username,' . $guru->user_id . ',user_id',
            'password' => 'nullable|min:6',
            'level' => 'required|in:guru,kesiswaan,wali_kelas',
            'nip' => 'nullable|max:50',
            'no_telepon' => 'nullable|max:20',
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'level' => $request->level,
            'nip' => $request->nip,
            'no_telepon' => $request->no_telepon,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $guru->update($data);

        return redirect()->route('guru.index')->with('success', 'Guru berhasil diupdate.');
    }

    public function destroy(User $guru)
    {
        $guru->delete();
        return redirect()->route('guru.index')->with('success', 'Guru berhasil dihapus.');
    }
}
