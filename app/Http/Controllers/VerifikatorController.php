<?php

namespace App\Http\Controllers;

use App\Models\Verifikator;
use App\Models\User;
use Illuminate\Http\Request;

class VerifikatorController extends Controller
{
    public function index()
    {
        $verifikator = Verifikator::with('user')->orderBy('nama_verifikator')->get();
        return view('verifikator.index', compact('verifikator'));
    }

    public function create()
    {
        $users = User::whereIn('level', ['kesiswaan', 'admin'])->get();
        return view('verifikator.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id|unique:verifikator,user_id',
            'nama_verifikator' => 'required|string|max:100',
            'nip' => 'nullable|string|max:50',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        Verifikator::create($request->all());

        return redirect()->route('verifikator.index')->with('success', 'Verifikator berhasil dibuat.');
    }

    public function show(Verifikator $verifikator)
    {
        $verifikator->load('user');
        return view('verifikator.show', compact('verifikator'));
    }

    public function edit(Verifikator $verifikator)
    {
        $users = User::whereIn('level', ['kesiswaan', 'admin'])->get();
        return view('verifikator.edit', compact('verifikator', 'users'));
    }

    public function update(Request $request, Verifikator $verifikator)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id|unique:verifikator,user_id,' . $verifikator->verifikator_id . ',verifikator_id',
            'nama_verifikator' => 'required|string|max:100',
            'nip' => 'nullable|string|max:50',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $verifikator->update($request->all());

        return redirect()->route('verifikator.index')->with('success', 'Verifikator berhasil diupdate.');
    }

    public function destroy(Verifikator $verifikator)
    {
        $verifikator->delete();
        return redirect()->route('verifikator.index')->with('success', 'Verifikator berhasil dihapus.');
    }
}
