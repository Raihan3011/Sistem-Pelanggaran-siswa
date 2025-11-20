<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Dashboard route
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifikasi', [\App\Http\Controllers\NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/{id}/read', [\App\Http\Controllers\NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    Route::post('/notifikasi/read-all', [\App\Http\Controllers\NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.read-all');
    
    Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{userId}', [\App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat', [\App\Http\Controllers\ChatController::class, 'store'])->name('chat.store');
    
    Route::middleware('orangtua.access')->group(function () {
        // Backup routes
        Route::get('/backup', [\App\Http\Controllers\BackupController::class, 'index'])->name('backup.index');
        Route::post('/backup/create', [\App\Http\Controllers\BackupController::class, 'create'])->name('backup.create');
        Route::get('/backup/download/{type}/{filename}', [\App\Http\Controllers\BackupController::class, 'download'])->name('backup.download');
        Route::delete('/backup/delete/{type}/{filename}', [\App\Http\Controllers\BackupController::class, 'delete'])->name('backup.delete');
        Route::post('/backup/restore/{type}/{filename}', [\App\Http\Controllers\BackupController::class, 'restore'])->name('backup.restore');
        
        // Resource routes
        Route::resource('siswa', \App\Http\Controllers\SiswaController::class);
        Route::resource('orang-tua', \App\Http\Controllers\OrangTuaController::class);
        Route::resource('pelanggaran', \App\Http\Controllers\PelanggaranController::class);
        Route::resource('jenis-pelanggaran', \App\Http\Controllers\JenisPelanggaranController::class);
        Route::resource('sanksi', \App\Http\Controllers\SanksiController::class);
        Route::resource('wali-kelas', \App\Http\Controllers\WaliKelasController::class);
        Route::post('wali-kelas/{wali_kelas}/assign-kelas', [\App\Http\Controllers\WaliKelasController::class, 'assignKelas'])->name('wali-kelas.assign-kelas');
        Route::resource('users', \App\Http\Controllers\UserController::class);
        Route::resource('bimbingan-konseling', \App\Http\Controllers\BimbinganKonselingController::class);
        Route::resource('prestasi', \App\Http\Controllers\PrestasiController::class);
        Route::resource('guru', \App\Http\Controllers\GuruController::class);
        Route::resource('tahun-ajaran', \App\Http\Controllers\TahunAjaranController::class);
        Route::post('tahun-ajaran/{tahunAjaran}/activate', [\App\Http\Controllers\TahunAjaranController::class, 'activate'])->name('tahun-ajaran.activate');
        Route::resource('kelas', \App\Http\Controllers\KelasController::class);
        Route::resource('jenis-sanksi', \App\Http\Controllers\JenisSanksiController::class);
        Route::resource('jenis-prestasi', \App\Http\Controllers\JenisPrestasiController::class);
        Route::resource('verifikator', \App\Http\Controllers\VerifikatorController::class);
        
        Route::get('verifikasi/pelanggaran', [\App\Http\Controllers\VerifikasiController::class, 'indexPelanggaran'])->name('verifikasi.pelanggaran');
        Route::put('verifikasi/pelanggaran/{pelanggaran}', [\App\Http\Controllers\VerifikasiController::class, 'verifikasiPelanggaran'])->name('verifikasi.pelanggaran.update');
        Route::get('verifikasi/prestasi', [\App\Http\Controllers\VerifikasiController::class, 'indexPrestasi'])->name('verifikasi.prestasi');
        Route::put('verifikasi/prestasi/{prestasi}', [\App\Http\Controllers\VerifikasiController::class, 'verifikasiPrestasi'])->name('verifikasi.prestasi.update');
        
        // Laporan routes
        Route::get('/laporan', [\App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/harian', [\App\Http\Controllers\LaporanController::class, 'harian'])->name('laporan.harian');
        Route::get('/laporan/bulanan', [\App\Http\Controllers\LaporanController::class, 'bulanan'])->name('laporan.bulanan');
        Route::get('/laporan/kelas', [\App\Http\Controllers\LaporanController::class, 'kelas'])->name('laporan.kelas');
        Route::get('/laporan/siswa', [\App\Http\Controllers\LaporanController::class, 'siswa'])->name('laporan.siswa');
        Route::get('/laporan/wali-kelas', [\App\Http\Controllers\LaporanController::class, 'waliKelas'])->name('laporan.wali-kelas');
        Route::get('/laporan/wali-kelas/pdf', [\App\Http\Controllers\LaporanController::class, 'waliKelasPdf'])->name('laporan.wali-kelas.pdf');
        Route::get('/laporan/kesiswaan', [\App\Http\Controllers\LaporanController::class, 'kesiswaan'])->name('laporan.kesiswaan');
        Route::get('/laporan/kesiswaan/pdf', [\App\Http\Controllers\LaporanController::class, 'kesiswaanPdf'])->name('laporan.kesiswaan.pdf');
        Route::get('/laporan/bk', [\App\Http\Controllers\LaporanController::class, 'bk'])->name('laporan.bk');
        Route::get('/laporan/bk/pdf', [\App\Http\Controllers\LaporanController::class, 'bkPdf'])->name('laporan.bk.pdf');
    });
});

// Authentication routes
require __DIR__.'/auth.php';

// Register routes (explicit definition)
Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);