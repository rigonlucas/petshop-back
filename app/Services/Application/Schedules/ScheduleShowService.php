<?php

namespace App\Services\Application\Schedules;

use App\Enums\SchedulesStatusEnum;
use App\Models\Schedules\Schedule;
use App\Services\Application\Schedules\DTO\ScheduleListData;
use App\Services\Application\Schedules\DTO\ScheduleShowData;
use App\Services\BaseService;
use App\Services\Filters\ApplyFilters;
use App\Services\Filters\Rules\DateAfterFilter;
use App\Services\Filters\Rules\DateBeforeFilter;
use App\Services\Filters\Rules\WhereEqualFilter;
use App\Services\Traits\HasEagerLoading;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ScheduleShowService extends BaseService
{
    use HasEagerLoading;

    private array $relationsAvailables = [
        'client',
        'pet',
        'user',
        'products.product'
    ];

    public function show(ScheduleShowData $data, int $scheduleId, int $accountId): Builder|array|Collection|Model
    {
        $query = Schedule::byAccount($accountId);
        $this->applyEagerLoadging($query, $data->include, $this->relationsAvailables);
        return $query->findOrFail($scheduleId);
    }
}