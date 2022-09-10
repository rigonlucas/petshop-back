<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\Controller;
use App\Http\Resources\Schedules\SchedulesResource;
use App\Services\Application\Schedules\DTO\ScheduleListData;
use App\Services\Application\Schedules\ScheduleListService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ScheduleListController extends Controller
{
    /**
     * @param Request $request
     * @param ScheduleListService $service
     * @return AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, ScheduleListService $service): AnonymousResourceCollection
    {
        $this->authorize('schedule_access');
        $data = ScheduleListData::fromRequest($request);
        $schedules = $service->list($data, $request->user()->account_id);

        return SchedulesResource::collection($schedules);
    }
}
