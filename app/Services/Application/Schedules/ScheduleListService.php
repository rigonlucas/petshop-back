<?php

namespace App\Services\Application\Schedules;

use App\Models\Schedule\Schedule;
use App\Services\Application\Schedules\DTO\ScheduleListData;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoadingIncludes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ScheduleListService extends BaseService
{
    use HasEagerLoadingIncludes;

    private Builder $schedule;

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

    public function openSchedules(ScheduleListData $data): self
    {
        $this->schedule = Schedule::openSchedule();
        $this->setRequestedIncludes(explode(',', $data->include));

        $this->schedule->when(
            $data->user_id,
            function ($query) use ($data){
                $query->where('user_id', '=', $data->user_id);
            }
        );

        $this->schedule->when(
            Carbon::canBeCreatedFromFormat($data->period_date, 'Y-m'),
            function ($query) use ($data) {
                $date = Carbon::create($data->period_date);
                $this->schedule
                    ->whereMonth('start_at', '=', $date->month)
                    ->whereYear('start_at', '=', $date->year);

            }
        );

        return $this;
    }

    public function getQuery(): Builder
    {
        $this->applyIncludesEagerLoading($this->schedule);
        $this->schedule->orderBy('start_at');

        return $this->schedule;
    }
}