<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->enum('tingkat', ['X', 'XI', 'XII'])->after('nama_kelas');
        });
    }

    public function down()
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn('tingkat');
        });
    }
};
