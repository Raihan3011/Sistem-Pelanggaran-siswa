<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunAjaran = TahunAjaran::orderBy('status_aktif', 'desc')
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'desc')
            ->get();
            
        return view('tahun-ajaran.index', compact('tahunAjaran'));
    }

    public function create()
    {
        return view('tahun-ajaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_tahun' => 'required|unique:tahun_ajaran|max:10',
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|in:1,2',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status_aktif' => 'boolean',
        ]);

        // Jika status_aktif dipilih, nonaktifkan yang lain
        if ($request->status_aktif) {
            TahunAjaran::where('status_aktif', true)->update(['status_aktif' => false]);
        }

        TahunAjaran::create($request->all());

        return redirect()->route('tahun-ajaran.index')->with('success', 'Tahun ajaran berhasil dibuat.');
    }

    public function show(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->loadCount(['waliKelas', 'pelanggaran', 'prestasi', 'bimbinganKonseling']);
        $tahunAjaran->load(['waliKelas.user', 'waliKelas.kelas']);
        
        return view('tahun-ajaran.show', compact('tahunAjaran'));
    }

    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('tahun-ajaran.edit', compact('tahunAjaran'));
    }

    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        $request->validate([
            'kode_tahun' => 'required|unique:tahun_ajaran,kode_tahun,' . $tahunAjaran->tahun_ajaran_id . ',tahun_ajaran_id|max:10',
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|in:1,2',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status_aktif' => 'boolean',
        ]);

        // Jika status_aktif dipilih, nonaktifkan yang lain
        if ($request->status_aktif) {
            TahunAjaran::where('status_aktif', true)
                ->where('tahun_ajaran_id', '!=', $tahunAjaran->tahun_ajaran_id)
                ->update(['status_aktif' => false]);
        }

        $tahunAjaran->update($request->all());

        return redirect()->route('tahun-ajaran.index')->with('success', 'Tahun ajaran berhasil diupdate.');
    }

    public function destroy(TahunAjaran $tahunAjaran)
    {
        if (!$tahunAjaran->canDelete()) {
            return redirect()->route('tahun-ajaran.index')->with('error', 
                'Tidak dapat menghapus tahun ajaran yang masih digunakan di data lain.');
        }

        $tahunAjaran->delete();
        return redirect()->route('tahun-ajaran.index')->with('success', 'Tahun ajaran berhasil dihapus.');
    }

    public function activate(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->activate();
        return redirect()->route('tahun-ajaran.index')->with('success', 'Tahun ajaran berhasil diaktifkan.');
    }
}