<?php

namespace Database\Factories;

use App\Enums\ProductsEnum;
use App\Models\User\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $costPrice = random_int(20, 100);
        return [
            'account_id' => Account::factory(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'type' => ProductsEnum::random(),
            'cost_price' => $costPrice,
            'price' => $costPrice + ($costPrice * (random_int(10, 35)/100)),
        ];
    }
}
