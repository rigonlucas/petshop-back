<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account = Account::factory()->create();
        Product::factory()->count(100)->create([
           'account_id' => $account->id
        ]);
    }
}
