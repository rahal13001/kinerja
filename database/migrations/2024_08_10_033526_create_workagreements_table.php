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
        Schema::create('workagreements', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pk');
            $table->integer('tahun_pk', false);
            $table->string('data_pk');
            $table->string('status_pk');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workagreements');
    }
};
