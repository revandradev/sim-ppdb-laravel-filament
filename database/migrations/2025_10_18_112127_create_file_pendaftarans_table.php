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
        Schema::create('file_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_pendaftaran_id');
            $table->string('file_name');
            $table->string('file_path');
            $table->foreign('user_pendaftaran_id')->references('id')->on('user_pendaftaran')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_pendaftaran');
    }
};
