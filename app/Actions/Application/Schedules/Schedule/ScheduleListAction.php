<?php

namespace App\Actions\Application\Schedules\Schedule;

use App\Actions\Application\Schedules\Schedule\DTO\ScheduleListData;
use App\Actions\BaseAction;
use App\Actions\Filters\ApplyFilters;
use App\Actions\Filters\Rules\DateAfterFilter;
use App\Actions\Filters\Rules\DateBeforeFilter;
use App\Actions\Filters\Rules\WhereEqualFilter;
use App\Actions\Traits\HasEagerLoading;
use App\Enums\SchedulesStatusEnum;
use App\Models\Schedules\Schedule;
use Illuminate\Contracts\Pagination\Paginator;

class ScheduleListAction extends BaseAction
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