<?php

namespace App\Http\Controllers;

use App\Models\JenisPelanggaran;
use Illuminate\Http\Request;

class JenisPelanggaranController extends Controller
{
    public function index()
    {
        $jenisPelanggaran = JenisPelanggaran::withCount('pelanggaran')
            ->orderBy('kategori')
            ->orderBy('point', 'desc')
            ->get();
            
        $kategoriStats = JenisPelanggaran::select('kategori')
            ->selectRaw('COUNT(*) as total_jenis, SUM(point) as total_point')
            ->groupBy('kategori')
            ->get();
            
        return view('jenis-pelanggaran.index', compact('jenisPelanggaran', 'kategoriStats'));
    }

    public function create()
    {
        $kategoriOptions = ['Ringan', 'Sedang', 'Berat', 'Sangat Berat'];
        
        return view('jenis-pelanggaran.create', compact('kategoriOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggaran' => 'required|unique:jenis_pelanggaran|max:200',
            'poin_minimal' => 'required|integer|min:1|max:100',
            'poin_maksimal' => 'required|integer|min:1|max:100|gte:poin_minimal',
            'kategori' => 'required|in:Ringan,Sedang,Berat,Sangat Berat',
            'deskripsi' => 'nullable',
            'sanksi_rekomendasi' => 'nullable',
        ]);

        JenisPelanggaran::create($request->all());

        return redirect()->route('jenis-pelanggaran.index')->with('success', 'Jenis pelanggaran berhasil dibuat.');
    }

    public function show(JenisPelanggaran $jenisPelanggaran)
    {
        $jenisPelanggaran->load(['pelanggaran.siswa.kelas']);
        
        return view('jenis-pelanggaran.show', compact('jenisPelanggaran'));
    }

    public function edit(JenisPelanggaran $jenisPelanggaran)
    {
        $kategoriOptions = ['Ringan', 'Sedang', 'Berat', 'Sangat Berat'];
        
        return view('jenis-pelanggaran.edit', compact('jenisPelanggaran', 'kategoriOptions'));
    }

    public function update(Request $request, JenisPelanggaran $jenisPelanggaran)
    {
        $request->validate([
            'nama_pelanggaran' => 'required|max:200|unique:jenis_pelanggaran,nama_pelanggaran,' . $jenisPelanggaran->jenis_pelanggaran_id . ',jenis_pelanggaran_id',
            'poin_minimal' => 'required|integer|min:1|max:100',
            'poin_maksimal' => 'required|integer|min:1|max:100|gte:poin_minimal',
            'kategori' => 'required|in:Ringan,Sedang,Berat,Sangat Berat',
            'deskripsi' => 'nullable',
            'sanksi_rekomendasi' => 'nullable',
        ]);

        $jenisPelanggaran->update($request->all());

        return redirect()->route('jenis-pelanggaran.index')->with('success', 'Jenis pelanggaran berhasil diupdate.');
    }

    public function destroy(JenisPelanggaran $jenisPelanggaran)
    {
        $jenisPelanggaran->delete();
        return redirect()->route('jenis-pelanggaran.index')->with('success', 'Jenis pelanggaran berhasil dihapus.');
    }

    public function statistik()
    {
        $totalJenis = JenisPelanggaran::count();
        
        $kategoriStats = JenisPelanggaran::select('kategori')
            ->selectRaw('COUNT(*) as total_jenis, AVG(point) as rata_rata_point')
            ->groupBy('kategori')
            ->get();

        return view('jenis-pelanggaran.statistik', compact('totalJenis', 'kategoriStats'));
    }

    public function byKategori($kategori)
    {
        $jenisPelanggaran = JenisPelanggaran::where('kategori', $kategori)
            ->orderBy('point', 'desc')
            ->get();
            
        return view('jenis-pelanggaran.by-kategori', compact('jenisPelanggaran', 'kategori'));
    }
}