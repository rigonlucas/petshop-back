<?php

namespace App\Services\Application\Schedules\Validators;

use App\Rules\Schedule\CanBookAScheduleRule;
use App\Rules\Schedule\CanUpdateBookAScheduleRule;
use App\Services\Application\Schedules\DTO\Base\ScheduleBaseData;
use App\Services\Application\Schedules\DTO\ScheduleUpdateData;

class ScheduleDateValidator
{
    public function validationsStore(ScheduleBaseData $data): array
    {
        return [
            "duration" => [
                'required',
                'min:1'
            ],
            "start_at" => [
                'required',
                'date_format:Y-m-d H:i:s',
                new CanBookAScheduleRule($data->user_id, $data->duration)
            ],
        ];
    }

    public function validationsUpdate(ScheduleUpdateData $data): array
    {
        return [
            "duration" => [
                'required',
                'min:1'
            ],
            "start_at" => [
                'required',
                'date_format:Y-m-d H:i:s',
                new CanUpdateBookAScheduleRule($data->schedule_id, $data->user_id, $data->duration)
            ],
        ];
    }
}