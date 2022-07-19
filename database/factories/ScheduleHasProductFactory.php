<?php

namespace Database\Factories;

use App\Enums\UnityEnum;
use App\Models\Product;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ScheduleHasProduct>
 */
class ScheduleHasProductFactory extends Factory
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
            'product_id' => Product::factory(),
            'schedule_id' => Schedule::factory(),
            'quantity' => random_int(1, 100),
            'price' => random_int(20, 100),
            'unity' => UnityEnum::random(),
            'discount' => random_int(5, 15)
        ];
    }
}
