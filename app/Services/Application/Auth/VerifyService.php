<?php

namespace App\Services\Application\Auth;

use App\Models\User;
use App\Services\BaseService;

class VerifyService extends BaseService
{
    public function register(string $hash): bool
    {
        $user = User::query()
            ->where('email_verificarion_hash', '=', $hash)
            ->first();
        return (bool) $user?->update([
            'email_verified_at' => now(),
            'email_verificarion_hash' => null
        ]);
    }
}