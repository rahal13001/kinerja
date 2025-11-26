<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indicator_id')->constrained()->cascadeOnDelete();
            $table->year('year');
            
            $table->decimal('target_q1', 15, 2)->nullable();
            $table->decimal('target_q2', 15, 2)->nullable();
            $table->decimal('target_q3', 15, 2)->nullable();
            $table->decimal('target_q4', 15, 2)->nullable();
            
            $table->decimal('achievement_q1', 15, 2)->nullable();
            $table->decimal('achievement_q2', 15, 2)->nullable();
            $table->decimal('achievement_q3', 15, 2)->nullable();
            $table->decimal('achievement_q4', 15, 2)->nullable();
            
            $table->text('description_q1')->nullable();
            $table->text('description_q2')->nullable();
            $table->text('description_q3')->nullable();
            $table->text('description_q4')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
