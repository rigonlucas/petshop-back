<?php

namespace App\Actions\Application\Schedules\Schedule;

use App\Actions\Application\Schedules\Schedule\DTO\ScheduleStatusData;
use App\Actions\BaseAction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ScheduleRescheduleAction extends BaseAction
{

    public function __construct(private readonly ScheduleStoreAction $scheduleStoreService)
    {
    }

    function reschedule(Model $schedule, ScheduleStatusData $data, User $user): void
    {
//        $scheduleStoreDTO = ScheduleData::fromArray($schedule->toArray());
//        $scheduleStoreDTO->start_at = $data->reschedule_date;
//        $scheduleStoreDTO->user_id = null;
//        $scheduleStoreDTO->status = SchedulesStatusEnum::OPEN->value;
//        $this->scheduleStoreService->store(
//            $scheduleStoreDTO,
//            $user
//        );
    }
}