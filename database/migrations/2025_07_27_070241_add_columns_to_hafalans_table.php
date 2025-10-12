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
        Schema::table('hafalans', function (Blueprint $table) {
            $table->foreignId('user_id')
                  ->nullable() // jika boleh kosong
                  ->constrained('users') // mengacu ke tabel 'users' kolom 'id'
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hafalans', function (Blueprint $table) {
            //
        });
    }
};
