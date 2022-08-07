<?php

namespace App\Services\Application\Auth;

use App\Exceptions\Auth\CredendialsWrongException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use function config;

class LoginService
{

    /**
     * @throws CredendialsWrongException
     */
    public function login (string $email, string $password)
    {
        $user = User::query()->select([
            'id', 'name', 'email', 'password', 'account_id', 'email_verified_at'
        ])
            ->whereEmail($email)
            ->with('account:id,name')
            ->first();
        if(!$user || !Hash::check($password, $user->password)){
            throw new CredendialsWrongException();
        }
        return [
            'user' => $user,
            'token' => $user->createToken('user')->plainTextToken,
            'expire_at' => config('sanctum.expiration')
        ];
    }
}