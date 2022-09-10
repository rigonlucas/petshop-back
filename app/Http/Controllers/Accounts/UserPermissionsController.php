<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Account\UserPermissionsRequest;
use App\Services\Application\Accounts\DTO\UserPermissionData;
use App\Services\Application\Accounts\UserPermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class UserPermissionsController extends Controller
{
    /**
     * @param UserPermissionsRequest $request
     * @param UserPermissionService $service
     * @return JsonResponse
     */
    public function __invoke(UserPermissionsRequest $request, UserPermissionService $service): JsonResponse
    {
        Gate::authorize('userAdmin', $request->user());
        $data = UserPermissionData::fromRequest($request);
        $data->account_id = $request->user()->account_id;
        $service->sync($data, $request->user());
        return response()->json();
    }
}
