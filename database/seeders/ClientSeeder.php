<?php

namespace Database\Seeders;

use App\Models\Clients\Client;
use App\Models\Clients\Pet;
use App\Models\Types\Breed;
use App\Models\Users\Account;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $account = Account::query()->first();
        $breed = Breed::query()->first() ?? Breed::factory()->create([
            'name' => 'Cachorro'
        ]);
        Client::factory()
            ->count(50)
            ->has(Pet::factory(
                [
                    'account_id' => $account->id,
                    'breed_id' => $breed->id
                ]
            )->count(random_int(1, 3)))
            ->create(
                [
                    'account_id' => $account->id
                ]
            );
    }
}
