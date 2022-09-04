<?php

namespace App\Services\Application\Accounts;

use App\Models\User;
use App\Services\Application\Accounts\DTO\AccountUserListData;
use App\Services\BaseService;
use App\Services\Filters\ApplyFilters;
use App\Services\Filters\Rules\WhereLikeFilter;
use App\Services\Ordinations\ApplyOrdination;
use App\Services\Ordinations\OrderBy;
use App\Services\Traits\HasEagerLoading;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;

class AccountUsersListService extends BaseService
{
    use HasEagerLoading;

    private array $relationsAvailables = [
        'account'
    ];

    public function list(AccountUserListData $data, int $accountId): CursorPaginator
    {
        $query = User::withTrashed()->byAccount($accountId);

        $ordination = [
            $data->order_by => new OrderBy($data->order_direction)
        ];
        $filters = [
            'name' => new WhereLikeFilter('name'),
        ];

        ApplyFilters::apply($query, $filters, $data->toArray());
        ApplyOrdination::apply($query, $ordination);

        $this->applyEagerLoadging($query, $data->include, $this->relationsAvailables);

        return $query->cursorPaginate($data->per_page);
    }
}