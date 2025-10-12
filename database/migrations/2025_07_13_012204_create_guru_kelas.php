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
        Schema::create('guru_kelas', function (Blueprint $table) {
            $table->id();
            // Relasi ke user (guru)
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // Relasi ke kelas tahfidz
            $table->foreignId('kelas_id')
                ->constrained()
                ->onDelete('cascade');


            // Opsional: agar tidak duplikat relasi
            $table->unique(['user_id', 'kelas_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_kelas');
    }
};
