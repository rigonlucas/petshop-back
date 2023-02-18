<?php

namespace App\Actions\Application\Clients;

use App\Actions\Application\Clients\DTO\ClientListData;
use App\Actions\BaseAction;
use App\Actions\Filters\ApplyFilters;
use App\Actions\Filters\Rules\WhereLikeFilter;
use App\Actions\Ordinations\ApplyOrdination;
use App\Actions\Ordinations\OrderBy;
use App\Actions\Traits\HasEagerLoading;
use App\Actions\Traits\HasEagerLoadingCount;
use App\Models\Clients\Client;
use Illuminate\Contracts\Pagination\CursorPaginator;

class ClientListAction extends BaseAction
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
        ApplyOrdination::apply($query, $ordination);
        $this->applyEagerLoadging($query, $data->include, $this->relationsAvailables);
        $this->applyEagerLoadgingCount($query, $data->include_count, $this->relationsAvailablesCount);

        return $query->cursorPaginate($data->per_page);
    }
}