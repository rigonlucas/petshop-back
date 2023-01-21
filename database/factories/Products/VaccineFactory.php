<?php

namespace Database\Factories\Products;

use App\Enums\VaccinesTypesEnum;
use App\Models\Products\Vaccine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vaccine>
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
            'number_first_shoot' => 1,
            'number_first_shoot_days' => random_int(200, 365),
            'days_to_booster_dose' => 60
        ];
    }
}
