<?php

namespace App\Actions\Application\Schedules\Status;

use App\Actions\Application\Schedules\Schedule\DTO\ScheduleStatusData;
use App\Actions\Application\Schedules\Validations\ScheduleStatusValidator;
use App\Actions\BaseAction;
use App\Enums\SchedulesStatusEnum;
use App\Models\Schedules\Schedule;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ExecutingAction extends BaseAction
{

    public function update(ScheduleStatusData $data, User $user): int
    {
        $data->account_id = $user->account_id;
        $data->status = SchedulesStatusEnum::EXECUTING->value;
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