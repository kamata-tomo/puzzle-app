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
        Schema::create('stamina_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('provider_id');
            $table->integer('change');
            $table->integer('reason_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stamina_logs');
    }
};
