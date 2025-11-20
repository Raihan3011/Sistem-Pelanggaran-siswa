<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jenis_sanksi', function (Blueprint $table) {
            $table->id('jenis_sanksi_id');
            $table->string('nama_sanksi', 100);
            $table->text('deskripsi');
            $table->integer('poin_minimal');
            $table->integer('poin_maksimal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_sanksi');
    }
};
