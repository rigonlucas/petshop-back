<?php

namespace App\Actions\Application\Accounts;

use App\Actions\Application\Accounts\DTO\AccountUserListData;
use App\Actions\BaseAction;
use App\Actions\Filters\ApplyFilters;
use App\Actions\Filters\Rules\WhereLikeFilter;
use App\Actions\Ordinations\ApplyOrdination;
use App\Actions\Ordinations\OrderBy;
use App\Actions\Traits\HasEagerLoading;
use App\Models\User;
use Illuminate\Contracts\Pagination\CursorPaginator;

class AccountUsersListAction extends BaseAction
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