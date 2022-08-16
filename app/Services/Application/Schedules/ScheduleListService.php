<?php

namespace App\Services\Application\Schedules;

use App\Enums\SchedulesStatusEnum;
use App\Models\Schedules\Schedule;
use App\Services\Application\Schedules\DTO\ScheduleListData;
use App\Services\BaseService;
use App\Services\Filters\ApplyFilters;
use App\Services\Filters\Rules\DateAfterFilter;
use App\Services\Filters\Rules\DateBeforeFilter;
use App\Services\Filters\Rules\WhereEqualFilter;
use App\Services\Relations\ApplyEagerLoading;
use Illuminate\Contracts\Pagination\Paginator;

class ScheduleListService extends BaseService
{
    private array $relationsAvailables = [
        'client',
        'pet',
        'user'
    ];

    public function list(ScheduleListData $data, int $accountId): Paginator
    {
        $query = Schedule::byAccount($accountId)
            ->where('status', '=', SchedulesStatusEnum::OPEN);
        $query->orderBy('start_at');

        $filters = [
            'start_at_start' => new DateAfterFilter('start_at'),
            'start_at_end' => new DateBeforeFilter('start_at'),
            'user_id' => new WhereEqualFilter('user_id'),
        ];
        ApplyFilters::apply($query, $filters, $data->toArray());
        ApplyEagerLoading::apply($query, $data->include, $this->relationsAvailables);

        return $query->simplePaginate($data->per_page);
    }
}