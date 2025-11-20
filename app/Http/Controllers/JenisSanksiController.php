<?php

namespace App\Http\Controllers;

use App\Models\JenisSanksi;
use Illuminate\Http\Request;

class JenisSanksiController extends Controller
{
    public function index()
    {
        $jenisSanksi = JenisSanksi::orderBy('poin_minimal')->get();
        return view('jenis-sanksi.index', compact('jenisSanksi'));
    }

    public function create()
    {
        return view('jenis-sanksi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sanksi' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'poin_minimal' => 'required|integer|min:0',
            'poin_maksimal' => 'required|integer|min:0|gte:poin_minimal',
        ]);

        JenisSanksi::create($request->all());

        return redirect()->route('jenis-sanksi.index')->with('success', 'Jenis sanksi berhasil dibuat.');
    }

    public function show(JenisSanksi $jenisSanksi)
    {
        return view('jenis-sanksi.show', compact('jenisSanksi'));
    }

    public function edit(JenisSanksi $jenisSanksi)
    {
        return view('jenis-sanksi.edit', compact('jenisSanksi'));
    }

    public function update(Request $request, JenisSanksi $jenisSanksi)
    {
        $request->validate([
            'nama_sanksi' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'poin_minimal' => 'required|integer|min:0',
            'poin_maksimal' => 'required|integer|min:0|gte:poin_minimal',
        ]);

        $jenisSanksi->update($request->all());

        return redirect()->route('jenis-sanksi.index')->with('success', 'Jenis sanksi berhasil diupdate.');
    }

    public function destroy(JenisSanksi $jenisSanksi)
    {
        $jenisSanksi->delete();
        return redirect()->route('jenis-sanksi.index')->with('success', 'Jenis sanksi berhasil dihapus.');
    }
}
