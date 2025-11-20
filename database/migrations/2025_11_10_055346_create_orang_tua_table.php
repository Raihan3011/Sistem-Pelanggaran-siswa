<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orang_tua', function (Blueprint $table) {
            $table->id('orang_tua_id');
            $table->foreignId('user_id')->nullable()->constrained('users', 'user_id');
            $table->foreignId('siswa_id')->constrained('siswa', 'siswa_id');
            $table->enum('hubungan', ['Ayah', 'Ibu', 'Wali']);
            $table->string('nama_orang_tua', 100);
            $table->string('pekerjaan', 50)->nullable();
            $table->string('pendidikan', 50)->nullable();
            $table->string('no_telp', 15)->nullable();
            $table->text('alamat');
            $table->timestamps();

            // Unique constraint: satu siswa hanya boleh punya satu ayah/ibu/wali
            $table->unique(['siswa_id', 'hubungan']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('orang_tua');
    }
};