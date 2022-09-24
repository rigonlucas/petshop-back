<?php

namespace App\Services\Application\Schedules\Schedule;

use App\Models\Schedules\Schedule;
use App\Services\Application\Schedules\Schedule\DTO\ScheduleShowData;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoading;

class ScheduleShowService extends BaseService
{
    use HasEagerLoading;

    private array $relationsAvailables = [
        'client',
        'pet',
        'user',
        'hasProducts.product',
        'hasVaccines.vaccine'
    ];

    public function show(ScheduleShowData $data, int $scheduleId, int $accountId): Schedule
    {
        $query = Schedule::byAccount($accountId);
        $this->applyEagerLoadging($query, $data->include, $this->relationsAvailables);
        /** @var Schedule */
        return $query->findOrFail($scheduleId);
    }
}