<?php

namespace App\Actions\Application\Auth;

use App\Actions\BaseAction;
use App\Models\User;

class LogoutAction extends BaseAction
{
    public function logout(User $auth)
    {
        return $auth->currentAccessToken()->delete();
    }
}