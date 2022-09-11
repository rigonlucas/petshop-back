<?php

namespace App\Services\Application\Schedules\Validations;

use App\Rules\Schedule\CanBookAScheduleRule;
use App\Services\Application\Schedules\DTO\Base\ScheduleData;

class ScheduleRecurrenceValidator
{
    public function validations(ScheduleData $data): array
    {
        $recurrence = [
            "recurrence" => [
                'nullable',
                'array',
            ],
        ];
        if (!$data->user_id) {
            return $recurrence;
        }
        return [
            ...$recurrence,
            "recurrence.*.duration" => [
                'required',
                'min:1'
            ],
            "recurrence.*.start_at" => [
                'required',
                'date_format:Y-m-d H:i:s',
                new CanBookAScheduleRule($data->user_id, $data->duration)
            ],
        ];
    }
}