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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('calon_siswa_id')->unique();
            $table->year('tahun_masuk')->default(date('Y'));
            $table->foreign('calon_siswa_id')->references('id')->on('calon_siswa')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('nisn')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
