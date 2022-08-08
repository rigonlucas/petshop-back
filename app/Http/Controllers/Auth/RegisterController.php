<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Auth\RegisterRequest;
use App\Services\Application\Auth\DTO\RegisterData;
use App\Services\Application\Auth\RegisterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RegisterController extends Controller
{

    public function __invoke(RegisterRequest $request, RegisterService $service): JsonResponse
    {
        $data = RegisterData::fromRequest($request);
        $result = DB::transaction(function () use ($data, $service) {
            return $service->register($data);
        });
        return response()->json($result, ResponseAlias::HTTP_CREATED);
    }

}