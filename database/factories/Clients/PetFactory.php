<?php

namespace Database\Factories\Clients;

use App\Models\Clients\Client;
use App\Models\Types\Breed;
use App\Models\Users\Account;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'breed_id' => Breed::factory(),
            'client_id' => Client::factory(),
            'account_id' => Account::factory(),
            'name' => $this->faker->name(),
            'birthday' => $this->faker->dateTimeBetween(
                Carbon::now()->subYears(5),
                Carbon::now()->subYear()
            )
        ];
    }
}
