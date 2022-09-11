<?php

namespace App\Services\Application\Schedules\Validations;

use App\Rules\Schedule\CanBookAScheduleRule;
use App\Rules\Schedule\CanUpdateBookAScheduleRule;
use App\Services\Application\Schedules\Schedule\DTO\ScheduleData;

class ScheduleDateValidator
{
    public function validationsStore(ScheduleData $data): array
    {
        $duration =[
            "duration" => [
                'required',
                'min:1'
            ],
        ];
        if (!$data->user_id) {
            return [
                ...$duration,
                "start_at" => [
                    'required',
                    'date_format:Y-m-d H:i:s',
                ],
            ];
        }
        return [
            ...$duration,
            "start_at" => [
                'required',
                'date_format:Y-m-d H:i:s',
                new CanBookAScheduleRule($data->user_id, $data->duration)
            ],
        ];
    }

    public function validationsUpdate(int $id, ScheduleData $data): array
    {
        return [
            "duration" => [
                'required',
                'min:1'
            ],
            "start_at" => [
                'required',
                'date_format:Y-m-d H:i:s',
                new CanUpdateBookAScheduleRule($id, $data->user_id, $data->duration)
            ],
        ];
    }
}