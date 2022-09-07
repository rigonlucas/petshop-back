<?php

namespace App\Services\Application\Schedules\Validators;

use App\Enums\SchedulesStatusEnum;
use App\Models\Schedules\Schedule;
use App\Rules\AccountHasEntityRule;
use App\Services\Application\Schedules\DTO\ScheduleStatusData;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class ScheduleStatusValidator
{
    /**
     * @throws ValidationException
     */
    protected function validateStatus(ScheduleStatusData $data): void
    {
        Validator::make($data->toArray(), [
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
            ],
        ])->validate();
    }
}