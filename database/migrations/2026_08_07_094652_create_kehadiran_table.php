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
        Schema::create('kehadiran', function (Blueprint $table) {

            $table->id();

            $table->foreignId('jadwal_sidang_id')
                ->constrained('jadwal_sidang')
                ->cascadeOnDelete();

            $table->foreignId('pihak_perkara_id')
                ->constrained('pihak_perkara')
                ->cascadeOnDelete();

            $table->enum('status', [
                'Belum Hadir',
                'Hadir'
            ])->default('Belum Hadir');

            $table->timestamp('waktu_hadir')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadiran');
    }
};
