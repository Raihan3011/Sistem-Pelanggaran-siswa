<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('wali_kelas', function (Blueprint $table) {
            $table->unsignedBigInteger('tahun_ajaran_id')->nullable()->after('wali_kelas_id');
            $table->foreign('tahun_ajaran_id')->references('tahun_ajaran_id')->on('tahun_ajaran')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('wali_kelas', function (Blueprint $table) {
            $table->dropForeign(['tahun_ajaran_id']);
            $table->dropColumn('tahun_ajaran_id');
        });
    }
};