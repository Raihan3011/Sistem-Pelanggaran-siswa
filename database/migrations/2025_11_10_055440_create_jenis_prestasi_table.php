<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jenis_prestasi', function (Blueprint $table) {
            $table->id('jenis_prestasi_id');
            $table->string('nama_prestasi', 200);
            $table->enum('jenis', ['Akademik', 'Non-Akademik', 'Olahraga', 'Seni', 'Lainnya']);
            $table->enum('kategori', ['Sekolah', 'Kecamatan', 'Kota', 'Provinsi', 'Nasional', 'Internasional']);
            $table->text('deskripsi')->nullable();
            $table->string('reward', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_prestasi');
    }
};