<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelaksanaan_sanksi', function (Blueprint $table) {
            $table->id();
            
            // PERBAIKAN: Reference ke 'pelanggaran_id' bukan 'id'
            $table->unsignedBigInteger('pelanggaran_id');
            $table->foreign('pelanggaran_id')->references('pelanggaran_id')->on('pelanggaran')->onDelete('cascade');
            
            // Untuk users (sudah benar)
            $table->unsignedBigInteger('guru_pengawas');
            $table->foreign('guru_pengawas')->references('user_id')->on('users')->onDelete('cascade');
            
            $table->text('deskripsi_pelaksanaan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status', ['pending', 'dalam_proses', 'selesai', 'dibatalkan'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelaksanaan_sanksi');
    }
};