<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Services\Application\Schedules\DTO\ScheduleAvailableProfessionalsData;
use App\Services\Application\Schedules\ScheduleAvailableProfessionalsService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AvailableProfessionalsController extends Controller
{
    public function __invoke(
        Request $request,
        string $dateTime,
        int $duration,
        ScheduleAvailableProfessionalsService $service): AnonymousResourceCollection
    {
        $data = ScheduleAvailableProfessionalsData::fromRequest($request);
        $data->account_id = $request->user()->account_id;
        $data->dateTime = $dateTime;
        $data->duration = $duration;

        $schedules = $service->list($data);
        return UserResource::collection($schedules);
    }
}
