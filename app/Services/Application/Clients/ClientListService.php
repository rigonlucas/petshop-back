<?php

namespace App\Services\Application\Clients;

use App\Models\Clients\Client;
use App\Services\Application\Clients\DTO\ClientListData;
use App\Services\BaseService;
use App\Services\Filters\ApplyFilters;
use App\Services\Filters\Rules\WhereLikeFilter;
use App\Services\Ordinations\ApplyOrdination;
use App\Services\Ordinations\OrderBy;
use App\Services\Traits\HasEagerLoading;
use App\Services\Traits\HasEagerLoadingCount;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;

class ClientListService extends BaseService
{
    use HasEagerLoading;
    use HasEagerLoadingCount;

    private array $relationsAvailables = [
        'account',
        'pets',
        'pets.breed',
        'registers',
    ];

    private array $relationsAvailablesCount = [
        'schedules'
    ];

    public function list(ClientListData $data, int $accountId): CursorPaginator
    {
        $query = Client::byAccount($accountId);

        $filters = [
            'name' => new WhereLikeFilter('name'),
        ];

        $ordination = [
            $data->order_by => new OrderBy($data->order_direction)
        ];

        ApplyFilters::apply($query, $filters, $data->toArray());
        ApplyOrdination::apply($query, $ordination, $data->toArray());
        $this->applyEagerLoadging($query, $data->include, $this->relationsAvailables);
        $this->applyEagerLoadgingCount($query, $data->include_count, $this->relationsAvailablesCount);

        return $query->cursorPaginate($data->per_page);
    }
}