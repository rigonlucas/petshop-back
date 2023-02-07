<?php

namespace App\Http\Controllers\Schedules\Schedule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Schedule\ScheduleUpdateRequest;
use App\Services\Application\Schedules\Schedule\DTO\ScheduleData;
use App\Services\Application\Schedules\Schedule\ScheduleUpdateService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ScheduleUpdateController extends Controller
{
    public function __invoke(ScheduleUpdateRequest $request, int $id, ScheduleUpdateService $service): JsonResponse
    {
        $data = ScheduleData::fromRequest($request);
        $schedule = $service->update(
            $id,
            $data,
            $request->user()
        );
        return response()->json(['data' => $schedule], ResponseAlias::HTTP_OK);
    }
}
