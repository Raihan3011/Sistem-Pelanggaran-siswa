<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOrangTuaAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->level == 'orang_tua') {
            $orangTua = \App\Models\OrangTua::where('user_id', auth()->id())->first();
            // Routes yang diizinkan untuk orang tua
            $allowedRoutes = [
                'dashboard',
                'siswa.index', 
                'siswa.show', 
                'pelanggaran.index', 
                'pelanggaran.show', 
                'sanksi.index', 
                'sanksi.show',
                'prestasi.index',
                'prestasi.show',
                'orang-tua.index',
                'orang-tua.show',
                'bimbingan-konseling.index',
                'bimbingan-konseling.show'
            ];
            
            // Cek apakah route saat ini diizinkan
            if (!$request->routeIs($allowedRoutes)) {
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
            
            // Validasi akses ke data siswa tertentu
            if ($request->routeIs(['siswa.show', 'pelanggaran.show', 'sanksi.show', 'bimbingan-konseling.show'])) {
                $siswaId = null;
                
                if ($request->routeIs('siswa.show')) {
                    $siswaId = $request->route('siswa')->siswa_id ?? null;
                } elseif ($request->routeIs('pelanggaran.show')) {
                    $pelanggaran = $request->route('pelanggaran');
                    $siswaId = $pelanggaran->siswa_id ?? null;
                } elseif ($request->routeIs('sanksi.show')) {
                    $sanksi = $request->route('sanksi');
                    $siswaId = $sanksi->pelanggaran->siswa_id ?? null;
                } elseif ($request->routeIs('bimbingan-konseling.show')) {
                    $bimbinganKonseling = \App\Models\BimbinganKonseling::find($request->route('bimbingan_konseling'));
                    $siswaId = $bimbinganKonseling->siswa_id ?? null;
                }
                
                // Pastikan orang tua hanya mengakses data anak mereka
                if ($siswaId && $siswaId != $orangTua->siswa_id) {
                    return redirect()->route('dashboard')->with('error', 'Anda hanya dapat mengakses data anak Anda sendiri.');
                }
            }
        }
        
        if (auth()->user()->level == 'wali_kelas') {
            // Routes yang diizinkan untuk wali kelas
            $allowedWaliKelasRoutes = [
                'dashboard',
                'siswa.index',
                'siswa.create',
                'siswa.store', 
                'siswa.show',
                'siswa.edit',
                'siswa.update',
                'siswa.destroy',
                'pelanggaran.index',
                'pelanggaran.create',
                'pelanggaran.store',
                'pelanggaran.show',
                'pelanggaran.edit',
                'pelanggaran.update',
                'pelanggaran.destroy',
                'sanksi.index',
                'sanksi.show',
                'orang-tua.index',
                'orang-tua.create',
                'orang-tua.store',
                'orang-tua.show',
                'orang-tua.edit',
                'orang-tua.update',
                'orang-tua.destroy',
                'laporan.wali-kelas',
                'laporan.wali-kelas.pdf'
            ];
            
            if (!$request->routeIs($allowedWaliKelasRoutes)) {
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        } elseif (auth()->user()->level == 'guru') {
            // Routes yang diizinkan untuk guru
            $allowedGuruRoutes = [
                'dashboard',
                'siswa.index',
                'siswa.create',
                'siswa.store',
                'siswa.show',
                'siswa.edit',
                'siswa.update',
                'siswa.destroy',
                'orang-tua.index',
                'orang-tua.show',
                'pelanggaran.index',
                'pelanggaran.create',
                'pelanggaran.store',
                'pelanggaran.show',
                'pelanggaran.edit',
                'pelanggaran.update',
                'pelanggaran.destroy',
                'sanksi.index',
                'sanksi.show'
            ];
            
            if (!$request->routeIs($allowedGuruRoutes)) {
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        } elseif (auth()->user()->level == 'siswa') {
            // Routes yang diizinkan untuk siswa
            $allowedSiswaRoutes = [
                'dashboard',
                'pelanggaran.index',
                'pelanggaran.show',
                'sanksi.index',
                'sanksi.show',
                'prestasi.index',
                'prestasi.show'
            ];
            
            if (!$request->routeIs($allowedSiswaRoutes)) {
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        }
        
        return $next($request);
    }
}
