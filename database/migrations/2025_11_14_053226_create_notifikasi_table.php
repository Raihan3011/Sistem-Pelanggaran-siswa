<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('notifikasi_id');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->string('judul');
            $table->text('pesan');
            $table->enum('tipe', ['pelanggaran', 'sanksi', 'prestasi', 'bimbingan', 'umum'])->default('umum');
            $table->foreignId('referensi_id')->nullable();
            $table->boolean('dibaca')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifikasi');
    }
};
