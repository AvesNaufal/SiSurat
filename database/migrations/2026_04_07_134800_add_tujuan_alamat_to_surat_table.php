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
        Schema::table('surat', function (Blueprint $table) {
            // Menyimpan: Instansi Tujuan (untuk izin-penelitian/pkl/kkl) 
            //            ATAU Alasan Cuti (untuk permohonan-cuti)
            $table->string('tujuan', 255)->nullable()->after('jenis_surat');
            // Menyimpan: Alamat Instansi (untuk izin-penelitian/pkl/kkl)
            $table->text('alamat')->nullable()->after('tujuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat', function (Blueprint $table) {
            $table->dropColumn(['tujuan', 'alamat']);
        });
    }
};
