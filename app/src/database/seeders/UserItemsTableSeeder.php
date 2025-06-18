<?php

namespace Database\Seeders;

use App\Models\UserItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $temps = [
            [
                'user_id' => 1,
                'item_id' => 1,
                'amount' => 50
            ]
            ,
            [
                'user_id' => 2,
                'item_id' => 2,
                'amount' => 10
            ]
            ,
            [
                'user_id' => 3,
                'item_id' => 3,
                'amount' => 1
            ]
        ];
        foreach ($temps as $temp) {
            UserItem::create($temp);
        }

    }
}
