<?php

namespace App\Services\Application\Schedules\Status;

use App\Enums\SchedulesStatusEnum;
use App\Models\Schedules\Schedule;
use App\Models\User;
use App\Services\Application\Schedules\Schedule\DTO\ScheduleStatusData;
use App\Services\Application\Schedules\Validations\ScheduleStatusValidator;
use App\Services\BaseService;
use Illuminate\Support\Facades\Validator;

class ArchivedService extends BaseService
{

    public function update(ScheduleStatusData $data, User $user): int
    {
        $data->account_id = $user->account_id;
        $data->status = SchedulesStatusEnum::ARCHIVED->value;
        $this->validate($data);

        return Schedule::query()
            ->where('id', '=', $data->schedule_id)
            ->update($data->except('schedule_id', 'account_id', 'reschedule_date')->toArray());
    }

    public function validate(ScheduleStatusData $data): void
    {
        Validator::make($data->toArray(), [
            ...(new ScheduleStatusValidator())->validateStatus($data)
        ])->validate();
    }
}