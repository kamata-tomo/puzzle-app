<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class AccountsTableSeeder extends Seeder
{


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::create([
            'name' => 'jobi',
            'password' => Hash::make('jobi')
        ]);

        //
    }
}
