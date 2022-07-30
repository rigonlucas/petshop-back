<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\Controller;
use App\Services\Application\Schedules\DTO\ScheduleDeleteData;
use App\Services\Application\Schedules\ScheduleDeleteService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ScheduleDeleteController extends Controller
{
    /**
     * @param Request $request
     * @param int $scheduleId
     * @param ScheduleDeleteService $service
     * @return Response
     */
    public function __invoke(Request $request, int $scheduleId, ScheduleDeleteService $service): Response
    {
        $data = ScheduleDeleteData::fromRequest($request);
        $data->schedule_id = $scheduleId;

        $service->delete($data, $request->user());
        return response()->noContent();
    }
}
