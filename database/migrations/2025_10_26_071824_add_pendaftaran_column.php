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
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->text('alamat_sekolah_sebelumnya')->nullable()->after('alamat');
            $table->text('akte_kelahiran')->nullable()->after('alamat_sekolah_sebelumnya');
            $table->text('kartu_keluarga')->nullable()->after('akte_kelahiran');
            $table->text('rapor_terakhir')->nullable()->after('kartu_keluarga');
            $table->text('ijazah')->nullable()->after('rapor_terakhir');
            $table->boolean('is_submitted')->default(false)->after('ijazah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn([
                'alamat_sekolah_sebelumnya',
                'akte_kelahiran',
                'kartu_keluarga',
                'rapor_terakhir',
                'ijazah',
                'is_submitted',
            ]);
        });
    }
};
