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
        Schema::table('jenis_pelanggaran', function (Blueprint $table) {
            $table->integer('poin_minimal')->default(1)->after('point');
            $table->integer('poin_maksimal')->default(15)->after('poin_minimal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jenis_pelanggaran', function (Blueprint $table) {
            $table->dropColumn(['poin_minimal', 'poin_maksimal']);
        });
    }
};
