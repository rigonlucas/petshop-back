<?php

namespace App\Services\Application\Schedules;

use App\Enums\SchedulesStatusEnum;
use App\Models\User;
use App\Services\Application\Schedules\DTO\ScheduleStatusData;
use App\Services\Application\Schedules\DTO\ScheduleStoreData;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;

class ScheduleRescheduleService extends BaseService
{

    public function __construct(private readonly ScheduleStoreService $scheduleStoreService)
    {
    }

    function reschedule(Model $schedule, ScheduleStatusData $data, User $user): void
    {
        $scheduleStoreDTO = ScheduleStoreData::fromArray($schedule->toArray());
        $scheduleStoreDTO->start_at = $data->reschedule_date;
        $scheduleStoreDTO->user_id = null;
        $scheduleStoreDTO->status = SchedulesStatusEnum::OPEN->value;
        $this->scheduleStoreService->store(
            $scheduleStoreDTO,
            $user
        );
    }
}