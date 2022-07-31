<?php

namespace App\Rules\Product;

use App\Models\Products\Product;
use Illuminate\Contracts\Validation\Rule;

class DeletedProductAccountExistsRule implements Rule
{
    public function __construct(private int $accountId)
    {
    }

    public function passes($attribute, $value)
    {
        return Product::onlyTrashed()
            ->byAccount($this->accountId)
            ->where('id', '=', $value)
            ->exists();
    }

    public function message()
    {
        return 'O produto não foi encontrado';
    }
}
