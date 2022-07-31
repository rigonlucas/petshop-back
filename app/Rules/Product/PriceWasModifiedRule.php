<?php

namespace App\Rules\Product;

use App\Models\Products\Product;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class PriceWasModifiedRule implements Rule
{
    public function __construct(private Product|Model $product, private float $newCostPrice)
    {
    }

    public function passes($attribute, $newPrice)
    {
        if ($this->product->cost_price != $this->newCostPrice || $this->product->price != $newPrice) {
            return true;
        }

        return false;
    }

    public function message()
    {
        return 'The validation error message.';
    }
}
