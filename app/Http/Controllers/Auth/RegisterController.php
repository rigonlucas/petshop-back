<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Application\Auth\DTO\RegisterData;
use App\Actions\Application\Auth\RegisterAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Auth\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RegisterController extends Controller
{

    public function __invoke(RegisterRequest $request, RegisterAction $service): JsonResponse
    {
        $data = RegisterData::fromRequest($request);
        $user = DB::transaction(function () use ($data, $service) {
            return $service->register($data);
        });
        $result = [
            'us er' => $user,
            'token' => $user->createToken('user')->plainTextToken,
            'expire_at' => config('sanctum.expiration')
        ];
        return response()->json(['data' => $result], ResponseAlias::HTTP_CREATED);
    }

}