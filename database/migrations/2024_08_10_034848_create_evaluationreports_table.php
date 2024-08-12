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
        Schema::create('evaluationreports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id');
            $table->string('nama_laporan');
            $table->integer('tahun_laporan', false);
            $table->string('data_laporan')->nullable();
            $table->string('status_laporan');
            $table->foreignId('team_id');
            $table->foreignId('indicator_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluationreports');
    }
};
