<?php

namespace App\Services\App\Accounts;

use App\Models\User;
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


    public function accountUsers(): self
    {
        $this->users = User::currentAccount()->withTrashed();
        return $this;
    }

    public function filterByName(?string $name): self
    {
        if ($name) {
            $this->users->where('name', 'like', '%'. $name .'%');
        }
        return $this;
    }

    public function getQuery(): Builder
    {
        $this->applyIncludesEagerLoading($this->users);
        return $this->users;
    }
}