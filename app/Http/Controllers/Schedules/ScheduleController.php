<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Schedule\ScheduleStoreRequest;
use App\Http\Requests\Application\Schedule\ScheduleUpdateRequest;
use App\Http\Resources\Schedules\SchedulesResource;
use App\Services\Application\Schedules\DTO\ScheduleListData;
use App\Services\Application\Schedules\DTO\ScheduleStoreData;
use App\Services\Application\Schedules\DTO\ScheduleUpdateData;
use App\Services\Application\Schedules\ScheduleListService;
use App\Services\Application\Schedules\ScheduleStoreService;
use App\Services\Application\Schedules\ScheduleUpdateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ScheduleController extends Controller
{
    public function index(Request $request, ScheduleListService $service): AnonymousResourceCollection
    {
        $data = ScheduleListData::fromRequest($request);
        $schedules = $service
            ->openSchedules($data)
            ->getQuery()
            ->paginate($data->per_page ?? 10);
        return SchedulesResource::collection($schedules);
    }

    /**
     * @param ScheduleStoreRequest $request
     * @param ScheduleStoreService $service
     * @return JsonResponse
     */
    public function store(ScheduleStoreRequest $request, ScheduleStoreService $service): JsonResponse
    {
        $data = ScheduleStoreData::fromRequest($request);
        $result = $service->store($data, $request->user());
        return response()->json([$result], ResponseAlias::HTTP_CREATED);
    }

    /**
     * @param ScheduleUpdateRequest $request
     * @param int $scheduleId
     * @param ScheduleUpdateService $service
     * @return JsonResponse
     */
    public function update(ScheduleUpdateRequest $request, int $scheduleId, ScheduleUpdateService $service): JsonResponse
    {
        $data = ScheduleUpdateData::fromRequest($request);
        $data->schedule_id = $scheduleId;
        $result = $service->update(
            $data,
            $request->user()
        );
        return response()->json(['row_updated' => $result], ResponseAlias::HTTP_OK);
    }
}
