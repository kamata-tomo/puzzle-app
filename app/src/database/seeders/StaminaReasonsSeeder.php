<?php

namespace Database\Seeders;

use App\Models\StaminaReasons;
use Illuminate\Database\Seeder;

class StaminaReasonsSeeder extends Seeder
{
    public function run(): void
    {
        StaminaReasons::create(['id' => 1, 'name' => 'クエスト消費']);
        StaminaReasons::create(['id' => 2, 'name' => 'アイテム回復']);
        StaminaReasons::create(['id' => 3, 'name' => 'フレンド回復']);
        StaminaReasons::create(['id' => 4, 'name' => 'レベルアップ回復']);
    }
}
