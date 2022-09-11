<?php

namespace App\Services\Application\Schedules\Status;

use App\Enums\SchedulesStatusEnum;
use App\Models\Schedules\Schedule;
use App\Models\User;
use App\Services\Application\Schedules\DTO\ScheduleStoreData;
use App\Services\Application\Schedules\Schedule\DTO\ScheduleStatusData;
use App\Services\Application\Schedules\Schedule\ScheduleRescheduleService;
use App\Services\Application\Schedules\Validations\ScheduleStatusValidator;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ScheduleCanceledService extends BaseService
{

    public function __construct(private readonly ScheduleRescheduleService $rescheduleService)
    {
    }

    public function update(ScheduleStatusData $data, User $user): int
    {
        $data->account_id = $user->account_id;
        $data->status = SchedulesStatusEnum::CANCELED->value;
        if ($data->reschedule_date) {
            $data->reschedule_date = Carbon::createFromDate($data->reschedule_date);
        }
        $schedule = Schedule::query()
            ->findOrFail($data->schedule_id);
        $this->validate($data, $schedule);
        return $this->updateStatus($schedule, $data, $user);
    }

    public function validate(ScheduleStatusData $data, Schedule $schedule): void
    {
        Validator::make($data->toArray(), [
            ...(new ScheduleStatusValidator())->validateStatus($data),
            'reschedule_date' => [
                'nullable',
                'date',
                'after:' . $schedule->finish_at
            ],
        ])->validate();
    }

    /**
     * @param Model $schedule
     * @param ScheduleStatusData $data
     * @param User $user
     * @return int
     */
    public function updateStatus(Model $schedule, ScheduleStatusData $data, User $user): int
    {
        return DB::transaction(function () use ($schedule, $data, $user) {
            if ($data->reschedule_date && $data->status != $schedule->status) {
                $this->rescheduleService->reschedule($schedule, $data, $user);
            }
            return $schedule->update(
                $data->except('schedule_id', 'account_id')->toArray()
            );
        });
    }
}