<?php

namespace App\Services\Application\Schedules\Validators;

use App\Enums\SchedulesStatusEnum;
use App\Enums\SchedulesTypesEnum;
use App\Models\Clients\Client;
use App\Models\Clients\Pet;
use App\Models\User;
use App\Rules\AccountHasEntityRule;
use App\Rules\Schedule\CanBookAScheduleRule;
use App\Services\Application\Schedules\DTO\Base\ScheduleBaseData;
use Illuminate\Validation\Rules\Enum;

class ScheduleValidator
{
    public function validations(ScheduleBaseData $data): array
    {
        return [
            "client_id" => [
                'required',
                'int',
                'min:1',
                new AccountHasEntityRule(Client::class, $data->account_id),
            ],
            "pet_id" => [
                'required',
                'int',
                'min:1',
                new AccountHasEntityRule(Pet::class, $data->account_id),
            ],
            "user_id" => [
                'nullable',
                'int',
                'min:1',
                new AccountHasEntityRule(User::class, $data->account_id),
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