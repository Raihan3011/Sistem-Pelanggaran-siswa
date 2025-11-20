<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bimbingan_konseling', function (Blueprint $table) {
            $table->id('bk_id');
            $table->foreignId('siswa_id')->constrained('siswa', 'siswa_id');
            $table->foreignId('guru_konselor')->constrained('users', 'user_id');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran', 'tahun_ajaran_id');
            $table->enum('jenis_layanan', ['Konseling Individual', 'Konseling Kelompok', 'Bimbingan Klasikal', 'Lainnya']);
            $table->string('topik', 200);
            $table->text('keluhan_masalah');
            $table->text('tindakan_solusi')->nullable();
            $table->enum('status', ['Pending', 'Proses', 'Selesai', 'Tindak Lanjut'])->default('Pending');
            $table->date('tanggal_konseling');
            $table->date('tanggal_tindak_lanjut')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bimbingan_konseling');
    }
};