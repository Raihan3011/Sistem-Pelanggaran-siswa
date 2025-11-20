<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sanksi', function (Blueprint $table) {
            $table->id('sanksi_id');
            $table->foreignId('pelanggaran_id')->constrained('pelanggaran', 'pelanggaran_id');
            $table->string('jenis_sanksi', 100);
            $table->text('deskripsi_sanksi');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['Dijadwalkan', 'Berjalan', 'Selesai', 'Dibatalkan'])->default('Dijadwalkan');
            $table->text('catatan_pelaksanaan')->nullable();
            $table->foreignId('guru_penanggung_jawab')->constrained('users', 'user_id');
            $table->timestamps();

            // Index untuk performa query
            $table->index('pelanggaran_id');
            $table->index('status');
            $table->index('tanggal_mulai');
            $table->index('guru_penanggung_jawab');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sanksi');
    }
};