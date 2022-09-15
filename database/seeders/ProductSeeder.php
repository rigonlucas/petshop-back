<?php

namespace Database\Seeders;

use App\Models\Products\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()->count(50)->create();
        if (true) {
            $products = [];
            for ($i = 0; $i < 40000; $i++) {
                $products [] = Product::factory()->make()->toArray();
            }
            foreach (array_chunk($products, 500) as $productsChunk) {
                Product::query()->insert($productsChunk);
            }
        }
    }
}
