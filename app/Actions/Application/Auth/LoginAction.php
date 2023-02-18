<?php

namespace App\Actions\Application\Auth;

use App\Exceptions\Auth\CredendialsWrongException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function config;

class LoginAction
{

    /**
     * @throws CredendialsWrongException
     */
    public function login(string $email, string $password)
    {
        $user = User::query()
            ->where('email', '=', $email)
            ->with(['account'])
            ->first();
        if (!$user || !Hash::check($password, $user->password)) {
            throw new CredendialsWrongException();
        }
        return [
            'user' => $user,
            'token' => $user->createToken('user')->plainTextToken,
            'expire_at' => config('sanctum.expiration')
        ];
    }
}