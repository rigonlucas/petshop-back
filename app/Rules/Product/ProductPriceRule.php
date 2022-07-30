<?php

namespace App\Rules\Product;

use Illuminate\Contracts\Validation\Rule;

class ProductPriceRule implements Rule
{
    public function __construct(private readonly float $costPrice)
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->costPrice > $value){
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O preço de custo é maor que o de venda';
    }
}
