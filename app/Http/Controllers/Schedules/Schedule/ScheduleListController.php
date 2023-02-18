<?php

namespace App\Http\Controllers\Schedules\Schedule;

use App\Actions\Application\Schedules\Schedule\DTO\ScheduleListData;
use App\Actions\Application\Schedules\Schedule\ScheduleListAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Schedules\SchedulesResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ScheduleListController extends Controller
{
    public function __invoke(Request $request, ScheduleListAction $service): AnonymousResourceCollection
    {
        $data = ScheduleListData::fromRequest($request);
        $schedules = $service->list($data, $request->user()->account_id);

        return SchedulesResource::collection($schedules);
    }
}
