<?php

namespace App\Services\Application\Accounts;

use App\Models\User;
use App\Services\Application\Accounts\DTO\AccountUserListData;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoadingIncludes;

class AccountUsersListService extends BaseService
{
    use HasEagerLoadingIncludes;

    function eagerIncludesRelations(): array
    {
        return [
            'account' => [
                'account'
            ]
        ];
    }

    public function list(AccountUserListData $data, int $accountId): \Illuminate\Contracts\Pagination\Paginator
    {
        $this->setRequestedIncludes(explode(',', $data->include));
        $users = User::byAccount($accountId);
        $users->when(
            $data->name,
            function ($query) use ($data) {
                $query->where('name', 'like', '%'. $data->name .'%');
            }
        );
        $this->setRequestedIncludes(explode(',', $data->include));
        $this->applyIncludesEagerLoading($users);

        return $users->simplePaginate($data->per_page);
    }
}