<?php

namespace App\Services\Application\Schedules;

use App\Models\Schedules\Schedule;
use App\Models\User;
use App\Services\Application\Schedules\DTO\ScheduleData;
use App\Services\Application\Schedules\DTO\ScheduleUpdateData;
use App\Services\Application\Schedules\Validations\ScheduleDateValidator;
use App\Services\Application\Schedules\Validations\ScheduleValidator;
use App\Services\BaseService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ScheduleUpdateService extends BaseService
{
    /**
     * @throws ValidationException
     */
    public function update(int $id, ScheduleData $data, User $user): Schedule
    {
        $this->validate($id, $user->account_id, $data);

        /** @var Schedule $schedule */
        $schedule = Schedule::query()
            ->where('account_id', '=', $user->account_id)
            ->find($id);

        $schedule->update($data->except('products')->toArray());
        return $schedule;
    }

    /**
     * @throws ValidationException
     */
    private function validate(int $id, int $account_id, ScheduleData $data): void
    {
        Validator::make($data->toArray(), [
            ...(new ScheduleValidator())->validations($account_id),
            ...(new ScheduleDateValidator())->validationsUpdate($id, $data),
        ])->validate();
    }
}