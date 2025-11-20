<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN level ENUM('admin', 'kesiswaan', 'guru', 'wali_kelas', 'bk', 'kepsek', 'siswa', 'orang_tua') NOT NULL");
    }

    public function down()
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN level ENUM('admin', 'kesiswaan', 'guru', 'wali_kelas', 'bk', 'kepsek', 'siswa') NOT NULL");
    }
};
