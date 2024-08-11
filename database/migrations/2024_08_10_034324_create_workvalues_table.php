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
        Schema::create('workvalues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id');
            $table->double('nilai_kinerja', 8, 3);
            $table->integer('tahun_kinerja', false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workvalues');
    }
};
