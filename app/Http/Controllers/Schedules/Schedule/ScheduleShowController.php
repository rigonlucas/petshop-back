<?php

namespace App\Http\Controllers\Schedules\Schedule;

use App\Actions\Application\Schedules\Schedule\DTO\ScheduleShowData;
use App\Actions\Application\Schedules\Schedule\ScheduleShowAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Schedules\SchedulesResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleShowController extends Controller
{
    public function __invoke(Request $request, ScheduleShowAction $service, int $id): JsonResource
    {
        $data = ScheduleShowData::fromRequest($request);
        $schedule = $service->show($data, $id, $request->user()->account_id);

        return SchedulesResource::make($schedule);
    }
}
