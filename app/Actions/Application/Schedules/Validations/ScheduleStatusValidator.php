<?php

namespace App\Actions\Application\Schedules\Validations;

use App\Enums\SchedulesStatusEnum;
use App\Models\Schedules\Schedule;
use App\Rules\AccountHasEntityRule;
use App\Actions\Application\Schedules\Schedule\DTO\ScheduleStatusData;
use Illuminate\Validation\Rules\Enum;

class ScheduleStatusValidator
{
    public function validateStatus(ScheduleStatusData $data): array
    {
        return [
            "schedule_id" => [
                'required',
                'int',
                'min:1',
                new AccountHasEntityRule(Schedule::class, $data->account_id),
            ],
            "status" => [
                'required',
                'int',
                'min:1',
                new Enum(SchedulesStatusEnum::class)
            ]
        ];
    }
}