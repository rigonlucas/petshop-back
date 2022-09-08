<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Account\UserCreateRequest;
use App\Http\Resources\User\UserResource;
use App\Services\Application\Accounts\DTO\UserCreateData;
use App\Services\Application\Accounts\UserCreateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class UserCreateController extends Controller
{
    public function __invoke(UserCreateRequest $request, UserCreateService $service): JsonResponse
    {
        Gate::authorize('create', $request->user());
        $data = UserCreateData::fromRequest($request);
        $accountUser = $service->create($data, $request->user());
        return response()->json(['data' => UserResource::make($accountUser)], 201);
    }
}
