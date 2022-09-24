<?php

namespace Database\Factories\Clients;

use App\Models\Clients\Pet;
use App\Models\Products\Vaccine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clients\PetVaccine>
 */
class PetVaccineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'vaccine_id' => Vaccine::factory(),
            'pet_id' => Pet::factory(),
            'schedule_id' => null,
        ];
    }
}
