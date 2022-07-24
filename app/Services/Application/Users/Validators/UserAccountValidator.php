<?php

namespace App\Services\Application\Users\Validators;

use App\Models\User;

class UserAccountValidator
{
    public static function userBelongsToAccount(int $userId, int $accountId): bool
    {
        return User::query()
            ->where('id', '=', $userId)
            ->where('account_id', '=', $accountId)
            ->exists();
    }
}