<?php

namespace App\Http\Controllers\Schedules\Schedule;

use App\Http\Controllers\Controller;
use App\Services\Application\Schedules\Schedule\DTO\ScheduleDeleteData;
use App\Services\Application\Schedules\Schedule\ScheduleDeleteService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ScheduleDeleteController extends Controller
{
    public function __invoke(Request $request, int $id, ScheduleDeleteService $service): Response
    {
        $data = ScheduleDeleteData::fromRequest($request);
        $data->schedule_id = $id;

        $service->delete($data, $request->user()->account_id);
        return response()->noContent();
    }
}
