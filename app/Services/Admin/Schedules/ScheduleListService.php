<?php

namespace App\Services\Admin\Schedules;

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
        return $query
//            ->with([
//                'client:id,name',
//                'pet:id,name,breed_id',
//                'pet.breed:id,name',
//                'user:id,name'
//            ])
            ->orderBy('start_at', 'asc')    ;
    }
}