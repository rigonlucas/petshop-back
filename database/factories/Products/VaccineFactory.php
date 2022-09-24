<?php

namespace Database\Factories\Products;

use App\Enums\VaccinesTypesEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products\Vaccine>
 */
class VaccineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text(500),
            'type' => VaccinesTypesEnum::random(),
            'days_to_booster_dose' => random_int(3, 12)
        ];
    }
}
