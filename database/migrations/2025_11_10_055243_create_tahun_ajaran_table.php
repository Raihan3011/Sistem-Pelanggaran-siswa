<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tahun_ajaran', function (Blueprint $table) {
            $table->id('tahun_ajaran_id');
            $table->string('kode_tahun', 10)->unique();
            $table->string('tahun_ajaran', 20);
            $table->enum('semester', [1, 2]);
            $table->boolean('status_aktif')->default(false);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tahun_ajaran');
    }
};