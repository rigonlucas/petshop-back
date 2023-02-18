<?php

namespace App\Actions\Application\Schedules\Schedule;

use App\Actions\Application\Schedules\Schedule\DTO\ScheduleAvailableProfessionalsData;
use App\Actions\BaseAction;
use App\Enums\SchedulesStatusEnum;
use App\Helpers\BuilderHelper;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class ScheduleAvailableProfessionalsAction extends BaseAction
{
    public function list(ScheduleAvailableProfessionalsData $data, int $accountId): Paginator
    {
        $this->validate($data);

        $startAt = Carbon::createFromFormat('Y-m-d H:i', $data->date_time);
        $finishAt = Carbon::createFromFormat('Y-m-d H:i', $data->date_time)->addMinutes($data->duration);

        $professionalsAvailable = User::byAccount($accountId)
            ->whereDoesntHave('schedules', function (Builder $builder) use ($startAt, $finishAt) {
                BuilderHelper::overlap($builder, 'start_at', 'finish_at', $startAt, $finishAt)
                    ->where('status', '=', SchedulesStatusEnum::SCHEDULED);
            });

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