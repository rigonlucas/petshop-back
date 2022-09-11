<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Schedule\ScheduleStoreRequest;
use App\Services\Application\Schedules\DTO\Base\ScheduleData;
use App\Services\Application\Schedules\ScheduleStoreService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ScheduleStoreController extends Controller
{
    /**
     * @param ScheduleStoreRequest $request
     * @param ScheduleStoreService $service
     * @return JsonResponse
     * @throws UnknownProperties
     * @throws AuthorizationException
     */
    public function __invoke(ScheduleStoreRequest $request, ScheduleStoreService $service): JsonResponse
    {
        $this->authorize('schedule_create');
        $data = ScheduleData::fromRequest($request);
        $result = $service->store($data, $request->user());
        return response()->json(['data' => $result], ResponseAlias::HTTP_CREATED);
    }
}
