<?php

namespace App\Services\Application\Schedules;

use App\Models\Schedules\Schedule;
use App\Models\User;
use App\Rules\AccountHasEntityRule;
use App\Services\Application\Schedules\DTO\ScheduleDeleteData;
use App\Services\BaseService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ScheduleDeleteService extends BaseService
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