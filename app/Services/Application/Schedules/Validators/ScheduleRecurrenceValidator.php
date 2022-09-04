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

class ScheduleRecurrenceValidator
{
    public function validations(ScheduleBaseData $data): array
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