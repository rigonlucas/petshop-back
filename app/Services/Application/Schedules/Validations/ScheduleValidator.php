<?php

namespace App\Services\Application\Schedules\Validations;

use App\Enums\SchedulesStatusEnum;
use App\Enums\SchedulesTypesEnum;
use App\Models\Clients\Client;
use App\Models\Clients\Pet;
use App\Models\User;
use App\Rules\AccountHasEntityRule;
use Illuminate\Validation\Rules\Enum;

class ScheduleValidator
{
    public function validations(int $account_id): array
    {
        return [
            "client_id" => [
                'required',
                'int',
                'min:1',
                new AccountHasEntityRule(Client::class, $account_id),
            ],
            "pet_id" => [
                'required',
                'int',
                'min:1',
                new AccountHasEntityRule(Pet::class, $account_id),
            ],
            "user_id" => [
                'nullable',
                'int',
                'min:1',
                new AccountHasEntityRule(User::class, $account_id),
            ],
            "type" => [
                'required',
                'int',
                'min:1',
                new Enum(SchedulesTypesEnum::class)
            ],
            "status" => [
                'required',
                'int',
                'min:1',
                new Enum(SchedulesStatusEnum::class)
            ],
            "description" => [
                'nullable',
                'string',
                'min:1',
                'max:500'
            ],
        ];
    }
}