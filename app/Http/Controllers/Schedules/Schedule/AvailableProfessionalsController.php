<?php

namespace App\Http\Controllers\Schedules\Schedule;

use App\Actions\Application\Schedules\Schedule\DTO\ScheduleAvailableProfessionalsData;
use App\Actions\Application\Schedules\Schedule\ScheduleAvailableProfessionalsAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AvailableProfessionalsController extends Controller
{
    public function __invoke(
        Request $request,
        ScheduleAvailableProfessionalsAction $service
    ): AnonymousResourceCollection {
        $data = ScheduleAvailableProfessionalsData::fromRequest($request);

        $schedules = $service->list($data, $request->user()->account_id);
        return UserResource::collection($schedules);
    }
}
