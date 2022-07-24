<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Auth\CredendialsWrongException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Auth\LoginRequest;
use App\Services\Application\Auth\AuthLoginService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    public function login(LoginRequest $request, AuthLoginService $authLoginService): JsonResponse
    {
        try {
            $login = $authLoginService->login($request->get('email'), $request->get('password'));
            return response()->json(['data' => $login]);
        } catch (CredendialsWrongException $exception) {
            return response()->json(['message' => 'Email ou senha invalidos'], 401);
        }
    }

}