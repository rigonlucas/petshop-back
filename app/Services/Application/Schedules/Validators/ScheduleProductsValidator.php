<?php

namespace App\Services\Application\Schedules\Validators;

use App\Models\Products\Product;
use App\Rules\AccountHasEntityRule;
use App\Services\Application\ScheduleProducts\DTO\ScheduleProductsStoreData;
use App\Services\Application\Schedules\DTO\Base\ScheduleBaseData;

class ScheduleProductsValidator
{
    /**
     * @param ScheduleBaseData|ScheduleProductsStoreData $data
     * @param string $requirementField [nullable ou required]
     * @return array
     */
    public function validations(
        ScheduleBaseData|ScheduleProductsStoreData $data,
        string                                     $requirementField = 'nullable'
    ): array
    {
        return [
            "products" => [
                $requirementField,
                'array',
            ],
            "products.*.product_id" => [
                'required',
                'integer',
                new AccountHasEntityRule(Product::class, $data->account_id),
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
                'nullable',
                'numeric',
                'gt:-1'
            ]
        ];
    }
}