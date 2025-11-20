<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id('prestasi_id');
            $table->foreignId('siswa_id')->constrained('siswa', 'siswa_id');
            $table->foreignId('guru_pencatat')->constrained('users', 'user_id');
            $table->foreignId('jenis_prestasi_id')->constrained('jenis_prestasi', 'jenis_prestasi_id');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran', 'tahun_ajaran_id');
            $table->integer('point');
            $table->text('keterangan')->nullable();
            $table->enum('tingkat', ['Sekolah', 'Kecamatan', 'Kota', 'Provinsi', 'Nasional', 'Internasional']);
            $table->string('penghargaan', 100)->nullable();
            $table->string('bukti_dokumen')->nullable();
            $table->enum('status_verifikasi', ['Pending', 'Terverifikasi', 'Ditolak'])->default('Pending');
            $table->foreignId('guru_verifikator')->nullable()->constrained('users', 'user_id');
            $table->date('tanggal');
            $table->timestamps();

            // Index untuk performa query
            $table->index('siswa_id');
            $table->index('status_verifikasi');
            $table->index('tanggal');
            $table->index('guru_pencatat');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prestasi');
    }
};