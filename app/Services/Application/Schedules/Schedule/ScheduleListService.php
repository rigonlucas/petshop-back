<?php

namespace App\Services\Application\Schedules\Schedule;

use App\Enums\SchedulesStatusEnum;
use App\Models\Schedules\Schedule;
use App\Services\Application\Schedules\Schedule\DTO\ScheduleListData;
use App\Services\BaseService;
use App\Services\Filters\ApplyFilters;
use App\Services\Filters\Rules\DateAfterFilter;
use App\Services\Filters\Rules\DateBeforeFilter;
use App\Services\Filters\Rules\WhereEqualFilter;
use App\Services\Traits\HasEagerLoading;
use Illuminate\Contracts\Pagination\Paginator;

class ScheduleListService extends BaseService
{
    use HasEagerLoading;

    private array $relationsAvailables = [
        'client',
        'pet',
        'user'
    ];

    public function list(ScheduleListData $data, int $accountId): Paginator
    {
        $query = Schedule::byAccount($accountId)
            ->where('status', '=', SchedulesStatusEnum::SCHEDULED);
        $query->orderBy('start_at');

        $filters = [
            'start_at_start' => new DateAfterFilter('start_at'),
            'start_at_end' => new DateBeforeFilter('start_at'),
            'user_id' => new WhereEqualFilter('user_id'),
        ];
        ApplyFilters::apply($query, $filters, $data->toArray());
        $this->applyEagerLoadging($query, $data->include, $this->relationsAvailables);

        return $query->paginate($data->per_page);
    }
}