<?php

namespace App\Actions\Application\Schedules\Schedule;

use App\Actions\Application\Schedules\Schedule\DTO\ScheduleShowData;
use App\Actions\BaseAction;
use App\Actions\Traits\HasEagerLoading;
use App\Models\Schedules\Schedule;

class ScheduleShowAction extends BaseAction
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