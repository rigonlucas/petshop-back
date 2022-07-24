<?php

namespace App\Services\Application\Schedules;

use App\Models\Schedule;
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

    public function openSchedules(): self
    {
        $this->schedule = Schedule::openSchedule();
        return $this;
    }

    public function filterBy(?int $userId): self
    {
        if ($userId) {
            $this->schedule->where('user_id', '=', $userId);
        }
        return $this;
    }

    public function setPeriodDate(?string $date): self
    {
        if (Carbon::canBeCreatedFromFormat($date, 'Y-m')) {
            $date = Carbon::create($date);
            $this->schedule
                ->whereMonth('start_at', '=', $date->month)
                ->whereYear('start_at', '=', $date->year);
        }
        return $this;
    }


    public function getQuery(): Builder
    {
        $this->applyIncludesEagerLoading($this->schedule);
        $this->schedule->orderBy('start_at');

        return $this->schedule;
    }
}