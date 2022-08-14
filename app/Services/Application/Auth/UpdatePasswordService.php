<?php

namespace App\Services\Application\Auth;

use App\Models\User;
use App\Notifications\Auth\ForgotPasswordNotify;
use App\Rules\Auth\CheckPasswordResetRule;
use App\Services\Application\Auth\DTO\UpdatePasswordData;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class UpdatePasswordService extends BaseService
{
    public function update(UpdatePasswordData $data, string $hash): bool
    {
        $passwordResets = DB::table('password_resets')
            ->where('email', '=', $data->email)
            ->where('expire_at', '>=', now())
            ->latest()
            ->first();
        $tokenHash = Hash::check($hash, $passwordResets?->token);
        $this->validate($data, $tokenHash);

        return (bool) DB::transaction(function () use ($data) {
            User::query()
                ->where('email', 'like', $data->email)
                ->update([
                    'password' => Hash::make($data->password)
                ]);
            DB::table('password_resets')
                ->where('email', '=', $data->email)
                ->delete();
        });
    }

    private function validate(UpdatePasswordData $data, bool $tokenHash): void
    {
        Validator::make(
            [
                ...$data->toArray(),
                'token' => $tokenHash
            ],
            [
                'email' => ['required', 'email'],
                'token' => ['required', 'boolean', new CheckPasswordResetRule()]
            ]
        )->validate();
    }
}