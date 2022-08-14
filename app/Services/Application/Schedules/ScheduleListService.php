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
use App\Services\Traits\HasEagerLoadingIncludes;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
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

    public function list(ScheduleListData $data, int $accountId): Paginator
    {
        $query = Schedule::byAccount($accountId)->where('status', '=', SchedulesStatusEnum::OPEN);
        $this->setRequestedIncludes(explode(',', $data->include));
        $this->applyIncludesEagerLoading($query);
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