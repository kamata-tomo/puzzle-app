<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 256);
            $table->integer('level')->default(1);
            $table->integer('experience')->default(0);
            $table->integer('item_quantity')->default(0);   //回復アイテム個数
            $table->date('last_login_date')->nullable();   // 最終ログイン日
            $table->integer('login_streak')->default(0);   // 連続ログイン日数
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
