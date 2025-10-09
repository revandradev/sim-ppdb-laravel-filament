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
        Schema::table('siswa', function (Blueprint $table) {
            // Drop foreign key constraint terlebih dahulu
            $table->dropForeign(['pendaftaran_id']);
            // Drop unique index
            $table->dropUnique(['pendaftaran_id']);
            // Tambahkan kembali foreign key tanpa unique jika perlu
            $table->foreign('pendaftaran_id')->references('id')->on('pendaftaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropForeign(['pendaftaran_id']);
            $table->unique('pendaftaran_id');
            $table->foreign('pendaftaran_id')->references('id')->on('pendaftaran');
        });
    }
};
