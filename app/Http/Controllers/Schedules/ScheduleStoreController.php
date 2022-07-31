<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Schedule\ScheduleStoreRequest;
use App\Services\Application\Schedules\DTO\ScheduleStoreData;
use App\Services\Application\Schedules\ScheduleStoreService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ScheduleStoreController extends Controller
{
    /**
     * @param ScheduleStoreRequest $request
     * @param ScheduleStoreService $service
     * @return JsonResponse
     */
    public function __invoke(ScheduleStoreRequest $request, ScheduleStoreService $service): JsonResponse
    {
        $data = ScheduleStoreData::fromRequest($request);
        $result = $service->store($data, $request->user());
        return response()->json([$result], ResponseAlias::HTTP_CREATED);
    }
}