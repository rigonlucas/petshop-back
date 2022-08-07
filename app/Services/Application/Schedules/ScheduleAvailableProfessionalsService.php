<?php

namespace App\Services\Application\Schedules;

use App\Models\Schedules\Schedule;
use App\Models\User;
use App\Services\Application\Schedules\DTO\ScheduleAvailableProfessionalsData;
use App\Services\Application\Schedules\DTO\ScheduleListData;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoadingIncludes;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;

class ScheduleAvailableProfessionalsService extends BaseService
{
    public function list(ScheduleAvailableProfessionalsData $data): Paginator
    {
        $startAt = Carbon::create($data->dateTime);
        $finishAt = Carbon::create($data->dateTime)->addMinutes($data->duration);

        $professionalScheduled = Schedule::byAccount($data->account_id)
            ->openSchedule()
            ->select('user_id')
            ->whereBetween('start_at', [$startAt, $finishAt])
            ->groupBy('user_id')
            ->get()
            ->pluck('user_id');
        $professionalsAvailable = User::byAccount($data->account_id)
            ->whereNotIn('id', $professionalScheduled);

        return $professionalsAvailable->simplePaginate($data->per_page);
    }
}