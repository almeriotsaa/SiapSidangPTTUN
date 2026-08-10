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
        Schema::create('jadwal_sidang', function (Blueprint $table) {

            $table->id();

            $table->foreignId('perkara_id')
                ->constrained('perkara')
                ->cascadeOnDelete();

            $table->date('tanggal_sidang');

            $table->time('jam_sidang');

            $table->string('ruang_sidang');

            $table->string('agenda_sidang');

            $table->foreignId('hakim_ketua_id')
                ->constrained('hakim');

            $table->foreignId('hakim_anggota1_id')
                ->constrained('hakim');

            $table->foreignId('hakim_anggota2_id')
                ->constrained('hakim');

            $table->foreignId('panitera_pengganti_id')
                ->constrained('panitera_pengganti');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_sidang');
    }
};
