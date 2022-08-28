<?php

namespace Database\Factories;

use App\Models\Clients\Client;
use App\Models\Users\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $account = Account::query()->first();
        return [
            'account_id' => $account ?? Account::factory(),
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber()
        ];
    }
}
