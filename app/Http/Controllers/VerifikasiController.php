<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\Prestasi;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function indexPelanggaran()
    {
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])
            ->where('status_verifikasi', 'Pending')
            ->orderBy('tanggal', 'desc')
            ->get();
            
        return view('verifikasi.pelanggaran', compact('pelanggaran'));
    }

    public function verifikasiPelanggaran(Request $request, Pelanggaran $pelanggaran)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:Terverifikasi,Ditolak',
            'catatan_verifikasi' => 'nullable|string',
        ]);

        $pelanggaran->update([
            'status_verifikasi' => $request->status_verifikasi,
            'guru_verifikator' => auth()->id(),
            'catatan_verifikasi' => $request->catatan_verifikasi,
        ]);

        return redirect()->route('verifikasi.pelanggaran')->with('success', 'Pelanggaran berhasil diverifikasi.');
    }

    public function indexPrestasi()
    {
        $prestasi = Prestasi::with(['siswa.kelas', 'jenisPrestasi', 'guruPencatat'])
            ->where('status_verifikasi', 'Pending')
            ->orderBy('tanggal', 'desc')
            ->get();
            
        return view('verifikasi.prestasi', compact('prestasi'));
    }

    public function verifikasiPrestasi(Request $request, Prestasi $prestasi)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:Terverifikasi,Ditolak',
            'catatan_verifikasi' => 'nullable|string',
        ]);

        $prestasi->update([
            'status_verifikasi' => $request->status_verifikasi,
            'guru_verifikator' => auth()->id(),
        ]);

        return redirect()->route('verifikasi.prestasi')->with('success', 'Prestasi berhasil diverifikasi.');
    }
}
