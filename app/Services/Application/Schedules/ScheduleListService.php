<?php

namespace App\Services\Application\Schedules;

use App\Enums\SchedulesStatusEnum;
use App\Models\Schedules\Schedule;
use App\Services\Application\Schedules\DTO\ScheduleListData;
use App\Services\BaseService;
use App\Services\Filters\ApplyFilters;
use App\Services\Filters\DateAfterFilter;
use App\Services\Filters\DateBeforeFilter;
use App\Services\Filters\WhereEqualFilter;
use Illuminate\Contracts\Pagination\Paginator;

class ScheduleListService extends BaseService
{
    public function list(ScheduleListData $data, int $accountId): Paginator
    {
        $includes = explode(',', $data->include);
        $query = Schedule::byAccount($accountId)->with($includes)->where('status', '=', SchedulesStatusEnum::OPEN);
//        $this->applyIncludesEagerLoading($query);
        $query->orderBy('start_at');

        $filters = [
            'start_at_start' => new DateAfterFilter('start_at'),
            'start_at_end' => new DateBeforeFilter('start_at'),
            'user_id' => new WhereEqualFilter('user_id'),
        ];
        ApplyFilters::apply($query, $filters, $data->toArray());

        return $query->simplePaginate($data->per_page);
    }
}