<?php

namespace App\Services\App\Schedules;

use App\Models\Schedule;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoadingIncludes;
use Illuminate\Database\Eloquent\Builder;

class ScheduleListService extends BaseService
{
    use HasEagerLoadingIncludes;

    protected function eagerIncludesRelations(): array
    {
        return [
            'pet' => [
                'pet.breed',
            ],
            'user' => [
                'user',
            ],
            'client' => [
                'client',
            ],
        ];
    }

    public function openSchedules(): Builder
    {
        $query = Schedule::openSchedule();
        $this->applyIncludesEagerLoading($query);
        return $query->orderBy('start_at');
    }
}