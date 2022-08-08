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
use Illuminate\Support\Facades\Validator;

class ScheduleAvailableProfessionalsService extends BaseService
{
    public function list(ScheduleAvailableProfessionalsData $data): Paginator
    {
        $this->validate($data);

        $startAt = Carbon::create($data->date_time);
        $finishAt = Carbon::create($data->date_time)->addMinutes($data->duration);

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

    private function validate(ScheduleAvailableProfessionalsData $data)
    {
        Validator::make($data->toArray(), [
            "duration" => [
                'required',
                'min:1'
            ],
            "date_time" => [
                'required',
                'date_format:Y-m-d H:i',
            ],
        ])->validate();
    }
}