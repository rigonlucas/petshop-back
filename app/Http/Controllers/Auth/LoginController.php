<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Auth\CredendialsWrongException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Auth\LoginRequest;
use App\Services\Application\Auth\LoginService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{

    public function __invoke(LoginRequest $request, LoginService $authLoginService): JsonResponse
    {
        try {
            $login = $authLoginService->login($request->validated('email'), $request->validated('password'));
            return response()->json(['data' => $login]);
        } catch (CredendialsWrongException $exception) {
            return response()->json(['message' => 'Email ou senha invalidos'], 401);
        }
    }

}