<?php

namespace App\Actions\Application\Auth;

use App\Actions\Application\Auth\DTO\UpdatePasswordData;
use App\Actions\BaseAction;
use App\Models\User;
use App\Rules\Auth\CheckPasswordResetRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UpdatePasswordAction extends BaseAction
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