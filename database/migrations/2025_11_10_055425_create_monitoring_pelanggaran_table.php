<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('monitoring_pelanggaran', function (Blueprint $table) {
            $table->id('monitor_id');
            $table->foreignId('pelanggaran_id')->constrained('pelanggaran', 'pelanggaran_id');
            $table->foreignId('guru_kepsek')->constrained('users', 'user_id');
            $table->enum('status_monitoring', ['Diproses', 'Ditindaklanjuti', 'Selesai', 'Dibatalkan'])->default('Diproses');
            $table->text('catatan_monitoring')->nullable();
            $table->date('tanggal_monitoring');
            $table->text('tindak_lanjut')->nullable();
            $table->timestamps();

            // Index untuk performa query
            $table->index('pelanggaran_id');
            $table->index('status_monitoring');
            $table->index('tanggal_monitoring');
        });
    }

    public function down()
    {
        Schema::dropIfExists('monitoring_pelanggaran');
    }
};