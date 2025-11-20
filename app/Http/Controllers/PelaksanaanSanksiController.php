<?php

namespace App\Http\Controllers;

use App\Models\PelaksanaanSanksi;
use App\Models\Sanksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PelaksanaanSanksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PelaksanaanSanksi::with(['sanksi.pelanggaran.siswa', 'guruPengawas']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by guru pengawas
        if ($request->has('guru_pengawas') && $request->guru_pengawas != '') {
            $query->where('guru_pengawas', $request->guru_pengawas);
        }

        // Filter by tanggal
        if ($request->has('tanggal_mulai') && $request->has('tanggal_selesai')) {
            $query->whereBetween('tanggal_pelaksanaan', [
                $request->tanggal_mulai,
                $request->tanggal_selesai
            ]);
        }

        // Search by nama siswa atau deskripsi
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('sanksi.pelanggaran.siswa', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })->orWhere('deskripsi_pelaksanaan', 'like', "%{$search}%");
        }

        $pelaksanaanSanksi = $query->latest()->paginate(10);

        $guruList = User::where('role', 'guru')->get();
        
        return view('pelaksanaan-sanksi.index', compact('pelaksanaanSanksi', 'guruList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sanksiList = Sanksi::with('pelanggaran.siswa')
            ->whereDoesntHave('pelaksanaanSanksi')
            ->orWhereHas('pelaksanaanSanksi', function($query) {
                $query->whereIn('status', ['Tidak Terlaksana', 'Ditunda']);
            })
            ->get();

        $guruList = User::where('role', 'guru')->get();

        return view('pelaksanaan-sanksi.create', compact('sanksiList', 'guruList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sanksi_id' => 'required|exists:sanksi,sanksi_id',
            'tanggal_pelaksanaan' => 'required|date',
            'deskripsi_pelaksanaan' => 'required|string|min:10',
            'bukti_pelaksanaan' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'status' => 'required|in:Terlaksana,Tidak Terlaksana,Ditunda,Dalam Proses',
            'catatan' => 'nullable|string|max:500',
            'guru_pengawas' => 'required|exists:users,id_user',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->except('bukti_pelaksanaan');

            // Handle file upload
            if ($request->hasFile('bukti_pelaksanaan')) {
                $file = $request->file('bukti_pelaksanaan');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('bukti-pelaksanaan', $filename, 'public');
                $data['bukti_pelaksanaan'] = $filename;
            }

            PelaksanaanSanksi::create($data);

            return redirect()->route('pelaksanaan-sanksi.index')
                ->with('success', 'Data pelaksanaan sanksi berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pelaksanaanSanksi = PelaksanaanSanksi::with([
            'sanksi.pelanggaran.siswa', 
            'sanksi.pelanggaran.jenisPelanggaran',
            'guruPengawas'
        ])->findOrFail($id);

        return view('pelaksanaan-sanksi.show', compact('pelaksanaanSanksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pelaksanaanSanksi = PelaksanaanSanksi::findOrFail($id);
        
        // Cek apakah bisa diubah
        if (!$pelaksanaanSanksi->bisaDiubah()) {
            return redirect()->route('pelaksanaan-sanksi.index')
                ->with('error', 'Data pelaksanaan sanksi yang sudah terlaksana/tidak terlaksana tidak dapat diubah.');
        }

        $sanksiList = Sanksi::with('pelanggaran.siswa')->get();
        $guruList = User::where('role', 'guru')->get();

        return view('pelaksanaan-sanksi.edit', compact('pelaksanaanSanksi', 'sanksiList', 'guruList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pelaksanaanSanksi = PelaksanaanSanksi::findOrFail($id);

        // Cek apakah bisa diubah
        if (!$pelaksanaanSanksi->bisaDiubah()) {
            return redirect()->route('pelaksanaan-sanksi.index')
                ->with('error', 'Data pelaksanaan sanksi yang sudah terlaksana/tidak terlaksana tidak dapat diubah.');
        }

        $validator = Validator::make($request->all(), [
            'sanksi_id' => 'required|exists:sanksi,sanksi_id',
            'tanggal_pelaksanaan' => 'required|date',
            'deskripsi_pelaksanaan' => 'required|string|min:10',
            'bukti_pelaksanaan' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'status' => 'required|in:Terlaksana,Tidak Terlaksana,Ditunda,Dalam Proses',
            'catatan' => 'nullable|string|max:500',
            'guru_pengawas' => 'required|exists:users,id_user',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->except('bukti_pelaksanaan');

            // Handle file upload
            if ($request->hasFile('bukti_pelaksanaan')) {
                // Delete old file if exists
                if ($pelaksanaanSanksi->bukti_pelaksanaan) {
                    Storage::disk('public')->delete('bukti-pelaksanaan/' . $pelaksanaanSanksi->bukti_pelaksanaan);
                }

                $file = $request->file('bukti_pelaksanaan');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('bukti-pelaksanaan', $filename, 'public');
                $data['bukti_pelaksanaan'] = $filename;
            }

            $pelaksanaanSanksi->update($data);

            return redirect()->route('pelaksanaan-sanksi.index')
                ->with('success', 'Data pelaksanaan sanksi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pelaksanaanSanksi = PelaksanaanSanksi::findOrFail($id);

        // Cek apakah bisa dihapus
        if (!$pelaksanaanSanksi->bisaDihapus()) {
            return redirect()->route('pelaksanaan-sanksi.index')
                ->with('error', 'Data pelaksanaan sanksi yang sudah terlaksana/tidak terlaksana tidak dapat dihapus.');
        }

        try {
            // Delete file if exists
            if ($pelaksanaanSanksi->bukti_pelaksanaan) {
                Storage::disk('public')->delete('bukti-pelaksanaan/' . $pelaksanaanSanksi->bukti_pelaksanaan);
            }

            $pelaksanaanSanksi->delete();

            return redirect()->route('pelaksanaan-sanksi.index')
                ->with('success', 'Data pelaksanaan sanksi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('pelaksanaan-sanksi.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update status pelaksanaan sanksi
     */
    public function updateStatus(Request $request, $id)
    {
        $pelaksanaanSanksi = PelaksanaanSanksi::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Terlaksana,Tidak Terlaksana,Ditunda,Dalam Proses',
            'catatan' => 'nullable|string|max:500',
            'bukti_pelaksanaan' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = ['status' => $request->status];

            if ($request->has('catatan')) {
                $data['catatan'] = $request->catatan;
            }

            // Handle file upload for status update
            if ($request->hasFile('bukti_pelaksanaan')) {
                // Delete old file if exists
                if ($pelaksanaanSanksi->bukti_pelaksanaan) {
                    Storage::disk('public')->delete('bukti-pelaksanaan/' . $pelaksanaanSanksi->bukti_pelaksanaan);
                }

                $file = $request->file('bukti_pelaksanaan');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('bukti-pelaksanaan', $filename, 'public');
                $data['bukti_pelaksanaan'] = $filename;
            }

            // Auto set tanggal pelaksanaan jika status menjadi Terlaksana
            if ($request->status === 'Terlaksana' && !$pelaksanaanSanksi->tanggal_pelaksanaan) {
                $data['tanggal_pelaksanaan'] = now()->format('Y-m-d');
            }

            $pelaksanaanSanksi->update($data);

            return redirect()->back()
                ->with('success', 'Status pelaksanaan sanksi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Download bukti pelaksanaan
     */
    public function downloadBukti($id)
    {
        $pelaksanaanSanksi = PelaksanaanSanksi::findOrFail($id);

        if (!$pelaksanaanSanksi->bukti_pelaksanaan) {
            return redirect()->back()
                ->with('error', 'File bukti tidak ditemukan.');
        }

        $filePath = storage_path('app/public/bukti-pelaksanaan/' . $pelaksanaanSanksi->bukti_pelaksanaan);

        if (!file_exists($filePath)) {
            return redirect()->back()
                ->with('error', 'File bukti tidak ditemukan di server.');
        }

        return response()->download($filePath);
    }

    /**
     * Get pelaksanaan sanksi by sanksi_id
     */
    public function getBySanksi($sanksiId)
    {
        $pelaksanaanSanksi = PelaksanaanSanksi::with(['guruPengawas'])
            ->where('sanksi_id', $sanksiId)
            ->get();

        return response()->json($pelaksanaanSanksi);
    }

    /**
     * Dashboard statistics
     */
    public function dashboard()
    {
        $total = PelaksanaanSanksi::count();
        $terlaksana = PelaksanaanSanksi::terlaksana()->count();
        $dalamProses = PelaksanaanSanksi::dalamProses()->count();
        $ditunda = PelaksanaanSanksi::ditunda()->count();
        $tidakTerlaksana = PelaksanaanSanksi::tidakTerlaksana()->count();

        $recentPelaksanaan = PelaksanaanSanksi::with(['sanksi.pelanggaran.siswa', 'guruPengawas'])
            ->latest()
            ->take(5)
            ->get();

        return view('pelaksanaan-sanksi.dashboard', compact(
            'total',
            'terlaksana',
            'dalamProses',
            'ditunda',
            'tidakTerlaksana',
            'recentPelaksanaan'
        ));
    }
}