<?php

namespace App\Services\Application\Schedules\Validators;

use App\Enums\SchedulesStatusEnum;
use App\Enums\SchedulesTypesEnum;
use App\Models\Clients\Client;
use App\Models\Clients\Pet;
use App\Models\Products\Product;
use App\Models\User;
use App\Rules\AccountHasEntityRule;
use App\Rules\Schedule\CanBookAScheduleRule;
use App\Services\Application\Schedules\DTO\Base\ScheduleBaseData;
use Illuminate\Validation\Rules\Enum;

class ScheduleProductsValidator
{
    public function validations(ScheduleBaseData $data): array
    {
        return [
            "products" => [
                'nullable',
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