<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();              //idカラム
            $table->string('name', 20);//nameカラム(20文字)
            $table->string('password', 256);
            $table->timestamps();//created_at, updated_at

            //$table->index('name');　　   //nameにインデックス設定
            $table->unique('name');    //nameにユニーク制約設定
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }

};
