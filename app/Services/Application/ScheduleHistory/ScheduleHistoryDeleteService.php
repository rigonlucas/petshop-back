<?php

namespace App\Services\Application\ScheduleHistory;

use App\Models\Schedules\Schedule;
use App\Models\Schedules\ScheduleHistory;
use App\Rules\AccountHasEntityRule;
use App\Rules\ScheduleHistory\ScheduleHistoryBelongsToPetRule;
use App\Services\Application\ScheduleHistory\DTO\ScheduleHistoryDeleteData;
use App\Services\BaseService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ScheduleHistoryDeleteService extends BaseService
{

    /**
     * @throws ValidationException
     */
    public function delete(ScheduleHistoryDeleteData $data): int
    {
        $this->validate($data);
        return ScheduleHistory::query()
            ->where('id', '=', $data->schedule_history_id)
            ->where('schedule_id', '=', $data->schedule_id)
            ->delete();
    }

    /**
     * @throws ValidationException
     */
    private function validate(ScheduleHistoryDeleteData $data): void
    {
        Validator::make(
            $data->toArray(),
            [
                'schedule_id' => [
                    'required',
                    'integer',
                    'min:1',
                    new AccountHasEntityRule(Schedule::class, $data->account_id),
                    new ScheduleHistoryBelongsToPetRule($data->schedule_history_id)
                ]
            ]
        )->validate();
    }
}