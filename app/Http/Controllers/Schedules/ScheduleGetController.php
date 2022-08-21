<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\Controller;
use App\Http\Resources\Schedules\SchedulesResource;
use App\Services\Application\Schedules\ScheduleListService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleGetController extends Controller
{
    public function __invoke(Request $request, ScheduleListService $service, int $id): JsonResource
    {
        return SchedulesResource::make($service->get($id, $request->user()->account_id));
    }
}
