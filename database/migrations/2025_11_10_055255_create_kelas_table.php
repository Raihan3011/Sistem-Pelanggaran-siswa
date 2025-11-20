<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id('kelas_id');
            $table->string('nama_kelas', 50);
            $table->enum('jurusan', ['PPLG', 'AKT', 'BDP', 'DKV', 'ANM']);
            $table->integer('kapasitas')->default(40);
            $table->foreignId('wali_kelas_id')->nullable()->constrained('users', 'user_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kelas');
    }
};