<?php

namespace App\Services\Application\Schedules\Status;

use App\Enums\SchedulesStatusEnum;
use App\Models\Schedules\Schedule;
use App\Models\User;
use App\Rules\AccountHasEntityRule;
use App\Services\Application\Schedules\DTO\ScheduleStatusData;
use App\Services\Application\Schedules\Validators\ScheduleStatusValidator;
use App\Services\BaseService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class ScheduleArchivedService extends ScheduleStatusValidator
{

    public function update(ScheduleStatusData $data, User $user): int
    {
        $data->account_id = $user->account_id;
        $data->status = SchedulesStatusEnum::ARCHIVED->value;
        $this->validateStatus($data);

        return Schedule::query()
            ->where('id', '=', $data->schedule_id)
            ->update($data->except('schedule_id', 'account_id')->toArray());
    }
}