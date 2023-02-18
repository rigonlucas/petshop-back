<?php

namespace App\Actions\Application\Auth;

use App\Actions\BaseAction;
use App\Models\User;
use App\Notifications\Auth\ForgotPasswordNotify;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

class ForgotPasswordAction extends BaseAction
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