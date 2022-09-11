<?php

namespace App\Http\Controllers\Schedules\Schedule;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Services\Application\Schedules\Schedule\DTO\ScheduleAvailableProfessionalsData;
use App\Services\Application\Schedules\Schedule\ScheduleAvailableProfessionalsService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AvailableProfessionalsController extends Controller
{
    /**
     * @param Request $request
     * @param ScheduleAvailableProfessionalsService $service
     * @return AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function __invoke(
        Request $request,
        ScheduleAvailableProfessionalsService $service): AnonymousResourceCollection
    {
        $this->authorize('schedule_access');
        $data = ScheduleAvailableProfessionalsData::fromRequest($request);

        $schedules = $service->list($data, $request->user()->account_id);
        return UserResource::collection($schedules);
    }
}
