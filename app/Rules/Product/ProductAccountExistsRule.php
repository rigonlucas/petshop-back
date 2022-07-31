<?php

namespace App\Rules\Product;

use App\Models\Products\Product;
use Illuminate\Contracts\Validation\Rule;

class ProductAccountExistsRule implements Rule
{
    public function __construct(private int $accountId)
    {
    }

    public function passes($attribute, $value)
    {
        return Product::byAccount($this->accountId)
            ->where('id', '=', $value)
            ->exists();
    }

    public function message()
    {
        return 'O produto não foi encontrado';
    }
}
