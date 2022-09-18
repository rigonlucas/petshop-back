<?php

namespace Database\Factories\Products;

use App\Enums\ProductsEnum;
use App\Models\Users\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
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
