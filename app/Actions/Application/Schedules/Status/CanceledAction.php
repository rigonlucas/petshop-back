<?php

namespace App\Actions\Application\Schedules\Status;

use App\Actions\Application\Schedules\DTO\ScheduleStoreData;
use App\Actions\Application\Schedules\Schedule\DTO\ScheduleStatusData;
use App\Actions\Application\Schedules\Schedule\ScheduleRescheduleAction;
use App\Actions\Application\Schedules\Validations\ScheduleStatusValidator;
use App\Actions\BaseAction;
use App\Enums\SchedulesStatusEnum;
use App\Models\Schedules\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CanceledAction extends BaseAction
{

    public function __construct(private readonly ScheduleRescheduleAction $rescheduleAction)
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
                $this->rescheduleAction->reschedule($schedule, $data, $user);
            }
            return $schedule->update(
                $data->except('schedule_id', 'account_id')->toArray()
            );
        });
    }
}