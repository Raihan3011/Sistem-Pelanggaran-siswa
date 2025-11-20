<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jenis_pelanggaran', function (Blueprint $table) {
            $table->id('jenis_pelanggaran_id');
            $table->string('nama_pelanggaran', 200);
            $table->integer('point');
            $table->enum('kategori', ['Ringan', 'Sedang', 'Berat', 'Sangat Berat']);
            $table->text('deskripsi')->nullable();
            $table->text('sanksi_rekomendasi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_pelanggaran');
    }
};