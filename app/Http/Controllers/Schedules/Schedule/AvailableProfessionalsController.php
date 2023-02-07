<?php

namespace App\Http\Controllers\Schedules\Schedule;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Services\Application\Schedules\Schedule\DTO\ScheduleAvailableProfessionalsData;
use App\Services\Application\Schedules\Schedule\ScheduleAvailableProfessionalsService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AvailableProfessionalsController extends Controller
{
    public function __invoke(
        Request $request,
        ScheduleAvailableProfessionalsService $service
    ): AnonymousResourceCollection {
        $data = ScheduleAvailableProfessionalsData::fromRequest($request);

        $schedules = $service->list($data, $request->user()->account_id);
        return UserResource::collection($schedules);
    }
}
