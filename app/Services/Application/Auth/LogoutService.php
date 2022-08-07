<?php

namespace App\Services\Application\Auth;

use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;

class LogoutService extends BaseService
{
    public function logout(User $auth)
    {
        return $auth->currentAccessToken()->delete();
    }
}