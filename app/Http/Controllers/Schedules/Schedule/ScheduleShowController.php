<?php

namespace App\Http\Controllers\Schedules\Schedule;

use App\Http\Controllers\Controller;
use App\Http\Resources\Schedules\SchedulesResource;
use App\Services\Application\Schedules\Schedule\DTO\ScheduleShowData;
use App\Services\Application\Schedules\Schedule\ScheduleShowService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleShowController extends Controller
{
    public function __invoke(Request $request, ScheduleShowService $service, int $id): JsonResource
    {
        $data = ScheduleShowData::fromRequest($request);
        $schedule = $service->show($data, $id, $request->user()->account_id);

        return SchedulesResource::make($schedule);
    }
}
