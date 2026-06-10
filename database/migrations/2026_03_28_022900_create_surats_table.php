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
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 15);
            $table->string('nama', 100)->nullable();
            $table->string('prodi', 100)->nullable();
            $table->integer('semester')->nullable();
            $table->string('jenis_surat', 50);
            $table->string('nomor_surat', 50)->nullable();
            $table->string('file_pdf', 255)->nullable();
            $table->datetime('tanggal')->nullable();

            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
