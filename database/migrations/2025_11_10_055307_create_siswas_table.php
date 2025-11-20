<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id('siswa_id');
            $table->foreignId('user_id')->nullable()->constrained('users', 'user_id');
            $table->string('nis', 20)->unique();
            $table->string('nisn', 20)->unique();
            $table->string('nama_siswa', 100);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir', 50);
            $table->text('alamat');
            $table->string('no_telp', 15)->nullable();
            $table->foreignId('kelas_id')->constrained('kelas', 'kelas_id');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('siswa');
    }
};