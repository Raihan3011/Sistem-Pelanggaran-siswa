<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pelanggaran', function (Blueprint $table) {
            $table->id('pelanggaran_id');
            $table->foreignId('siswa_id')->constrained('siswa', 'siswa_id');
            $table->foreignId('guru_pencatat')->constrained('users', 'user_id');
            $table->foreignId('jenis_pelanggaran_id')->constrained('jenis_pelanggaran', 'jenis_pelanggaran_id');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran', 'tahun_ajaran_id');
            $table->integer('point');
            $table->text('keterangan')->nullable();
            $table->string('bukti_foto')->nullable();
            $table->enum('status_verifikasi', ['Pending', 'Terverifikasi', 'Ditolak'])->default('Pending');
            $table->foreignId('guru_verifikator')->nullable()->constrained('users', 'user_id');
            $table->text('catatan_verifikasi')->nullable();
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
        Schema::dropIfExists('pelanggaran');
    }
};