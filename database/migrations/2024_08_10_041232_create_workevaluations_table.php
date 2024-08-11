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
        Schema::create('workevaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workplan_id');
            $table->date('tgl_realisasi')->nullable();
            $table->text('kendala')->nullable();
            $table->text('saran')->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->string('bukti_tindak_lanjut')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('komentar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workevaluations');
    }
};
