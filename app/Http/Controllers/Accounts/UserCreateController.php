<?php

namespace App\Http\Controllers\Accounts;

use App\Actions\Application\Accounts\DTO\UserCreateData;
use App\Actions\Application\Accounts\UserCreateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Account\UserCreateRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\JsonResponse;

class UserCreateController extends Controller
{
    public function __invoke(UserCreateRequest $request, UserCreateAction $service): JsonResponse
    {
        $data = UserCreateData::fromRequest($request);
        $accountUser = $service->create($data, $request->user());
        return response()->json(['data' => UserResource::make($accountUser)], 201);
    }
}
