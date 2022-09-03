<?php

namespace Database\Factories\Types;

use App\Enums\BreedsEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Types\Breed>
 */
class BreedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'type' => BreedsEnum::random()
        ];
    }
}
