<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Breed;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
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
