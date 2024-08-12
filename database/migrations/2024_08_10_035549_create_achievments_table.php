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
        Schema::create('achievments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indicator_id');
            $table->integer('tahun_achievment', false);
            $table->double('target_achievment', 8, 3);
            $table->double('realisasi_achievment', 8, 3);
            $table->string('bukti_achievment');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievments');
    }
};
