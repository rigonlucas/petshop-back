<?php

namespace App\Services\Application\Schedules\Validations;

use App\Rules\Schedule\CanBookAScheduleRule;
use App\Services\Application\Schedules\DTO\ScheduleData;

class ScheduleRecurrenceValidator
{
    public function validations(ScheduleData $data): array
    {

        return [
//            ...$recurrence,

        ];
    }
}