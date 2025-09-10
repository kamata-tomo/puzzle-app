<?php

namespace Database\Seeders;

use App\Models\Titles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TitlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i <= 9; $i++) {
            Titles::create(['chapter_num' => $i,'name' => "Chapter{$i}全ステージクリア"]);
            Titles::create(['chapter_num' => $i,'name' => "Chapter{$i}全ステージ星3クリア"]);
            Titles::create(['chapter_num' => $i,'name' => "Chapter{$i}全ステージ完全クリア"]);
        }
    }
}
