<?php

namespace App\Services\Application\Accounts;

use App\Models\User;
use App\Services\Application\Accounts\DTO\AccountUserListData;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoadingIncludes;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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

    public function list(AccountUserListData $data, int $accountId): LengthAwarePaginator
    {
        $this->setRequestedIncludes(explode(',', $data->include));
        $this->users = User::byAccount($accountId);
        $this->users->when(
            $data->name,
            function ($query) use ($data) {
                $query->where('name', 'like', '%'. $data->name .'%');
            }
        );
        return $this->users->paginate($data->per_page ?? 10);
    }
}