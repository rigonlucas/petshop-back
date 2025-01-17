<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function userAdmin(User $user)
    {
        return $user->hasRole('User Admin')
            || $user->hasPermissionTo('user_management_access');
    }
    /**
     * @param User $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->hasRole('User Admin');
    }
}
