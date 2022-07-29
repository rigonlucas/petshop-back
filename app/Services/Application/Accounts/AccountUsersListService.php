<?php

namespace App\Services\Application\Accounts;

use App\Models\User;
use App\Services\Application\Accounts\DTO\AccountUserListData;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoadingIncludes;
use Illuminate\Database\Eloquent\Builder;

class AccountUsersListService extends BaseService
{
    use HasEagerLoadingIncludes;

    private Builder $users;

    function eagerIncludesRelations(): array
    {
        return [
            'account' => [
                'account'
            ]
        ];
    }


    public function accountUsers(AccountUserListData $data, int $accountId): self
    {
        $this->setRequestedIncludes(explode(',', $data->include));
        $this->users = User::byAccount($accountId);
        $this->users->when(
            $data->name,
            function ($query) use ($data) {
                $query->where('name', 'like', '%'. $data->name .'%');
            }
        );
        return $this;
    }

    public function getQuery(): Builder
    {
        $this->applyIncludesEagerLoading($this->users);
        return $this->users;
    }
}