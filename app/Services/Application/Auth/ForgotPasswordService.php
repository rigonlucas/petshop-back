<?php

namespace App\Services\Application\Auth;

use App\Models\User;
use App\Notifications\Auth\ForgotPasswordNotify;
use App\Services\BaseService;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

class ForgotPasswordService extends BaseService
{
    public function newPassword(string $email): void
    {
        $user = User::query()
            ->firstWhere('email', 'like', $email);
        if ($user) {
            $recoveryHash = Password::createToken($user);
            Notification::route('mail', $user->email)->notify(new ForgotPasswordNotify($user, $recoveryHash));
        }
    }
}