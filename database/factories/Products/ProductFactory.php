<?php

namespace Database\Factories\Products;

use App\Enums\ProductsEnum;
use App\Enums\ProductsUnitEnum;
use App\Models\Product\Product;
use App\Models\Users\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
        $account = Account::query()->first();
        return [
            'account_id' => $account ?? Account::factory(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'type' => ProductsEnum::random(),
            'cost' => $costPrice,
            'price' => $costPrice + ($costPrice * (random_int(20, 50) / 100)),
        ];
    }
}
