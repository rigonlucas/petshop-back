<?php

namespace App\Actions\Application\Schedules\Validations;

use App\Models\Products\Product;
use App\Rules\AccountHasEntityRule;

class ScheduleProductsValidator
{
    public function validations(int $account_id): array
    {
        return [
            "products" => [
                'nullable',
                'array',
            ],
            "products.*.product_id" => [
                'required',
                'integer',
                new AccountHasEntityRule(Product::class, $account_id),
            ],
            "products.*.quantity" => [
                'required',
                'integer',
                'gt:0'
            ],
            "products.*.price" => [
                'required',
                'numeric',
                'gt:-1'
            ],
            "products.*.discount" => [
                'numeric',
                'gt:-1'
            ]
        ];
    }
}