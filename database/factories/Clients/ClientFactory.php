<?php

namespace Database\Factories\Clients;

use App\Models\Users\Account;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'account_uid' => Str::uuid(),
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
        ];
    }
}
