<?php

namespace App\Actions\Application\Auth;

use App\Actions\BaseAction;
use App\Models\User;

class VerifyAction extends BaseAction
{
    public function register(string $hash): bool
    {
        $user = User::query()
            ->where('email_verificarion_hash', '=', $hash)
            ->first();
        return (bool)$user?->update([
            'email_verified_at' => now(),
            'email_verificarion_hash' => null
        ]);
    }
}