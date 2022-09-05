<?php

namespace App\Services\Application\Accounts;

use App\Models\User;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ChangeStatusUsersService extends BaseService
{
    public function change(Mixed $user): void
    {
        if (!$user->deleted_at) {
            $user->delete();
        } else {
            $user->restore();
        }
    }

    public function findUser(int $id): Model|Collection|Builder|array|null
    {
        return User::withTrashed()->find($id);
    }
}