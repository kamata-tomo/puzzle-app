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
        Schema::create('stamina_statuses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('current_stamina')->default(10);
            $table->integer('max_stamina')->default(10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stamina_statuses');
    }
};
