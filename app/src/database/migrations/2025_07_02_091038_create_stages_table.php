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
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->integer('chapter_num');
            $table->integer('stage_num');
            $table->integer('shuffle_count');
            $table->boolean('score_criteria_is_time')->default(false);
            $table->integer('reference_value_1');
            $table->integer('reference_value_2');
            $table->integer('reference_value_3');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stages');
    }
};
