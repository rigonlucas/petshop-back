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
     * @param int $id
     * @param ScheduleUpdateService $service
     * @return JsonResponse
     */
    public function __invoke(ScheduleUpdateRequest $request, int $id, ScheduleUpdateService $service): JsonResponse
    {
        $this->authorize('schedule_edit');
        $data = ScheduleUpdateData::fromRequest($request);
        $data->schedule_id = $id;
        $result = $service->update(
            $data,
            $request->user()
        );
        return response()->json(['row_updated' => $result], ResponseAlias::HTTP_OK);
    }
}
