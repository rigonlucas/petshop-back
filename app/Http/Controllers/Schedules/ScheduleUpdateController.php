<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Schedule\ScheduleUpdateRequest;
use App\Services\Application\Schedules\DTO\ScheduleUpdateData;
use App\Services\Application\Schedules\ScheduleUpdateService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ScheduleUpdateController extends Controller
{
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
