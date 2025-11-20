<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->string('rombel', 10)->nullable()->after('jurusan');
        });
    }

    public function down()
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn('rombel');
        });
    }
};
