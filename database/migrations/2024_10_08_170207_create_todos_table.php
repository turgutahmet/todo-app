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
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->unique();
            $table->string('provider');
            $table->integer('difficulty');
            $table->integer('duration');
            $table->timestamps();
            $table->softDeletes();

            //indexes
            $table->index(['difficulty', 'duration'], 'idx_difficulty_duration');
            $table->index('provider');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
