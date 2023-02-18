<?php

namespace App\Actions\Application\Schedules\Schedule;

use App\Actions\Application\Schedules\Schedule\DTO\ScheduleDeleteData;
use App\Actions\BaseAction;
use App\Models\Schedules\Schedule;
use App\Rules\AccountHasEntityRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ScheduleDeleteAction extends BaseAction
{

    public function delete(ScheduleDeleteData $data, int $account_id): int
    {
        $data->account_id = $account_id;
        $this->validate($data);

        return Schedule::query()
            ->where('id', '=', $data->schedule_id)
            ->delete();
    }

    /**
     * @throws ValidationException
     */
    private function validate(ScheduleDeleteData $data): void
    {
        Validator::make($data->toArray(), [
            "schedule_id" => [
                'required',
                'int',
                'min:1',
                new AccountHasEntityRule(Schedule::class, $data->account_id),
            ],
        ])->validate();
    }
}