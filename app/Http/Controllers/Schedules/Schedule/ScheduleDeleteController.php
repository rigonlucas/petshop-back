<?php

namespace App\Http\Controllers\Schedules\Schedule;

use App\Actions\Application\Schedules\Schedule\DTO\ScheduleDeleteData;
use App\Actions\Application\Schedules\Schedule\ScheduleDeleteAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ScheduleDeleteController extends Controller
{
    public function __invoke(Request $request, int $id, ScheduleDeleteAction $service): Response
    {
        $data = ScheduleDeleteData::fromRequest($request);
        $data->schedule_id = $id;

        $service->delete($data, $request->user()->account_id);
        return response()->noContent();
    }
}
