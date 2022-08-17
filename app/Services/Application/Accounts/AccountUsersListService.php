<?php

namespace App\Services\Application\Accounts;

use App\Models\User;
use App\Services\Application\Accounts\DTO\AccountUserListData;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoading;
use Illuminate\Contracts\Pagination\Paginator;

class AccountUsersListService extends BaseService
{
    use HasEagerLoading;

    private array $relationsAvailables = [
        'account'
    ];

    public function list(AccountUserListData $data, int $accountId): Paginator
    {
        $users = User::byAccount($accountId);
        $users->when(
            $data->name,
            function ($query) use ($data) {
                $query->where('name', 'like', '%'. $data->name .'%');
            }
        );
        $this->applyEagerLoadging($users, $data->include, $this->relationsAvailables);

        return $users->simplePaginate($data->per_page);
    }
}