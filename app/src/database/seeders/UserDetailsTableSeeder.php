<?php

namespace Database\Seeders;

use App\Models\UserDetails;
use App\Models\UserItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $temps = [
            [
                'user_id' => 1,
                'age' => 20
            ]
            ,
            [
                'user_id' => 2,
                'age' => 18

            ]
            ,
            [
                'user_id' => 3,
                'age' => 26
            ]
        ];
        foreach ($temps as $temp) {
            userDetails::create($temp);
        }
    }
}
