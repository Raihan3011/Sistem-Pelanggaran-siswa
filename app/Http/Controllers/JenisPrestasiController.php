<?php

namespace App\Http\Controllers;

use App\Models\JenisPrestasi;
use Illuminate\Http\Request;

class JenisPrestasiController extends Controller
{
    public function index()
    {
        $jenisPrestasi = JenisPrestasi::orderBy('nama_prestasi')->get();
            
        return view('jenis-prestasi.index', compact('jenisPrestasi'));
    }

    public function create()
    {
        $jenisOptions = ['Akademik', 'Non-Akademik', 'Olahraga', 'Seni', 'Lainnya'];
        $kategoriOptions = ['Sekolah', 'Kecamatan', 'Kota', 'Provinsi', 'Nasional', 'Internasional'];
        
        return view('jenis-prestasi.create', compact('jenisOptions', 'kategoriOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_prestasi' => 'required|unique:jenis_prestasi|max:200',
            'deskripsi' => 'nullable',
        ]);

        JenisPrestasi::create($request->all());

        return redirect()->route('jenis-prestasi.index')->with('success', 'Jenis prestasi berhasil dibuat.');
    }

    public function show(JenisPrestasi $jenisPrestasi)
    {
        $jenisPrestasi->load([
            'prestasi' => function($query) {
                $query->with(['siswa.kelas', 'userPencatat'])
                    ->orderBy('tanggal', 'desc');
            }
        ]);
        
        $statistik = $jenisPrestasi->getStatistikPenggunaan();
        $rekomendasiPoint = $jenisPrestasi->getRekomendasiPoint();
        
        return view('jenis-prestasi.show', compact('jenisPrestasi', 'statistik', 'rekomendasiPoint'));
    }

    public function edit(JenisPrestasi $jenisPrestasi)
    {
        $jenisOptions = ['Akademik', 'Non-Akademik', 'Olahraga', 'Seni', 'Lainnya'];
        $kategoriOptions = ['Sekolah', 'Kecamatan', 'Kota', 'Provinsi', 'Nasional', 'Internasional'];
        
        return view('jenis-prestasi.edit', compact('jenisPrestasi', 'jenisOptions', 'kategoriOptions'));
    }

    public function update(Request $request, JenisPrestasi $jenisPrestasi)
    {
        $request->validate([
            'nama_prestasi' => 'required|max:200|unique:jenis_prestasi,nama_prestasi,' . $jenisPrestasi->jenis_prestasi_id . ',jenis_prestasi_id',
            'deskripsi' => 'nullable',
        ]);

        $jenisPrestasi->update($request->all());

        return redirect()->route('jenis-prestasi.index')->with('success', 'Jenis prestasi berhasil diupdate.');
    }

    public function destroy(JenisPrestasi $jenisPrestasi)
    {
        if (!$jenisPrestasi->canBeDeleted()) {
            return redirect()->route('jenis-prestasi.index')->with('error', 
                'Tidak dapat menghapus jenis prestasi yang sudah digunakan.');
        }

        $jenisPrestasi->delete();
        return redirect()->route('jenis-prestasi.index')->with('success', 'Jenis prestasi berhasil dihapus.');
    }

    public function statistik()
    {
        $totalJenis = JenisPrestasi::count();
        $palingSering = JenisPrestasi::palingSering(10)->get();
        
        $jenisStats = JenisPrestasi::select('jenis')
            ->selectRaw('COUNT(*) as total_jenis')
            ->groupBy('jenis')
            ->get();

        $kategoriStats = JenisPrestasi::select('kategori')
            ->selectRaw('COUNT(*) as total_jenis')
            ->groupBy('kategori')
            ->get();

        $pointDistribution = JenisPrestasi::all()->map(function($jenis) {
            return [
                'nama_prestasi' => $jenis->nama_prestasi,
                'point' => $jenis->getPointReward(),
                'kategori' => $jenis->kategori_text,
                'jenis' => $jenis->jenis_text,
            ];
        });

        return view('jenis-prestasi.statistik', compact(
            'totalJenis',
            'palingSering',
            'jenisStats',
            'kategoriStats',
            'pointDistribution'
        ));
    }

    public function byJenis($jenis)
    {
        $jenisPrestasi = JenisPrestasi::where('jenis', $jenis)
            ->orderBy('kategori')
            ->orderBy('nama_prestasi')
            ->get();
            
        $jenisText = (new JenisPrestasi())->getJenisTextAttribute($jenis);
            
        return view('jenis-prestasi.by-jenis', compact('jenisPrestasi', 'jenis', 'jenisText'));
    }

    public function byKategori($kategori)
    {
        $jenisPrestasi = JenisPrestasi::where('kategori', $kategori)
            ->orderBy('jenis')
            ->orderBy('nama_prestasi')
            ->get();
            
        $kategoriText = (new JenisPrestasi())->getKategoriTextAttribute($kategori);
            
        return view('jenis-prestasi.by-kategori', compact('jenisPrestasi', 'kategori', 'kategoriText'));
    }
}