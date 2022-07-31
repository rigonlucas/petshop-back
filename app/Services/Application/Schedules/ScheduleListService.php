<?php

namespace App\Services\Application\Schedules;

use App\Models\Schedules\Schedule;
use App\Services\Application\Schedules\DTO\ScheduleListData;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoadingIncludes;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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

    public function list(ScheduleListData $data): LengthAwarePaginator
    {
        $schedule = Schedule::openSchedule();
        $this->setRequestedIncludes(explode(',', $data->include));
        $this->applyIncludesEagerLoading($schedule);
        $schedule->orderBy('start_at');

        $schedule->when(
            $data->user_id,
            function ($query) use ($data) {
                $query->where('user_id', '=', $data->user_id);
            }
        );

        $schedule->when(
            Carbon::canBeCreatedFromFormat($data->period_date, 'Y-m'),
            function ($query) use ($data, $schedule) {
                $date = Carbon::create($data->period_date);
                $schedule
                    ->whereMonth('start_at', '=', $date->month)
                    ->whereYear('start_at', '=', $date->year);

            }
        );

        return $schedule->paginate($data->per_page ?? 10);
    }
}