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
            $table->unsignedBigInteger('user_id'); // 外部キー用にunsigned推奨
            $table->integer('current_stamina')->default(10);
            $table->integer('max_stamina')->default(10);
            $table->timestamp('last_updated_at')->nullable(); // ← 回復計算用に追加
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
