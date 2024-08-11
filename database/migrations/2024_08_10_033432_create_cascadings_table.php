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
        Schema::create('cascadings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_cascading');
            $table->string('tahun_cascading');
            $table->string('data_cascading');
            $table->string('status_cascading');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cascadings');
    }
};
