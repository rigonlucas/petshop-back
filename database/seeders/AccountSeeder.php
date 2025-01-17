<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Users\Account;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account = Account::factory()->create();
        User::factory()->createMany(
            [
                [
                    'email' => 'lucas@teste.com',
                    'account_id' => $account->id,
                    'password' => Hash::make('123'),
                ],
                [
                    'email' => 'lauro@teste.com',
                    'account_id' => $account->id,
                    'password' => Hash::make('123')
                ]
            ]
        );
        DB::insert('insert into trial_codes ( name, code) values (?, ?)', ['teste', '1234AAAA']);
    }
}
