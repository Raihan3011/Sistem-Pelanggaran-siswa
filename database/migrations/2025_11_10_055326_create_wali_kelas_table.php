<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wali_kelas', function (Blueprint $table) {
            $table->id('wali_kelas_id');
            $table->string('nip', 20)->unique();
            $table->string('nama_guru', 100);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('bidang_studi', 50);
            $table->string('email')->unique();
            $table->string('no_telp', 15)->nullable();
            $table->enum('status', ['Aktif', 'Non-Aktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wali_kelas');
    }
};