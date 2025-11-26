<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performance_goal_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('performance_goal_id')->constrained()->cascadeOnDelete();
            $table->string('revision_name');
            $table->date('revision_date');
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_goal_changes');
    }
};
