<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $temps = [
            [
                'name' => '回復薬',
                'type' => '消耗品',
                'effect_value' => 10,
                'FlavorText' => '傷を癒やすための薬、効果は低い'
            ],
            [
                'name' => '上級回復薬',
                'type' => '消耗品',
                'effect_value' => 50,
                'FlavorText' => '傷を癒やすための薬、欠損部位まで治すと言われている'
            ],
            [
                'name' => 'エリクサー',
                'type' => '消耗品',
                'effect_value' => 9999,
                'FlavorText' => '生きてさえいれば完全な状態まで回復させると言われる伝説の薬'
            ]
        ];
        foreach ($temps as $temp) {
            Item::create($temp);
        }
    }
}
