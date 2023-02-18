<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Application\Auth\DTO\UpdatePasswordData;
use App\Actions\Application\Auth\UpdatePasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Auth\UpdatePasswordRequest;
use Illuminate\Http\JsonResponse;

class UpdatePasswordController extends Controller
{
    public function __invoke(UpdatePasswordRequest $request, string $hash, UpdatePasswordAction $service): JsonResponse
    {
        $data = UpdatePasswordData::fromRequest($request);
        $service->update($data, $hash);
        return response()->json();
    }
}
