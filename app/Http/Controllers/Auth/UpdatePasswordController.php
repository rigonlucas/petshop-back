<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Auth\UpdatePasswordRequest;
use App\Services\Application\Auth\DTO\UpdatePasswordData;
use App\Services\Application\Auth\UpdatePasswordService;
use Illuminate\Http\JsonResponse;

class UpdatePasswordController extends Controller
{
    public function __invoke(UpdatePasswordRequest $request, string $hash, UpdatePasswordService $service): JsonResponse
    {
        $data = UpdatePasswordData::fromRequest($request);
        $service->update($data, $hash);
        return response()->json();
    }
}
