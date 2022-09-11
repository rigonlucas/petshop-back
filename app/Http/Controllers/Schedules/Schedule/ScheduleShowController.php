<?php

namespace App\Http\Controllers\Schedules\Schedule;

use App\Http\Controllers\Controller;
use App\Http\Resources\Schedules\SchedulesResource;
use App\Services\Application\Schedules\Schedule\DTO\ScheduleShowData;
use App\Services\Application\Schedules\Schedule\ScheduleShowService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleShowController extends Controller
{
    /**
     *
     * Query string: include=client,pet,user,products.product
     *
     * @param Request $request
     * @param ScheduleShowService $service
     * @param int $id
     * @return JsonResource
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, ScheduleShowService $service, int $id): JsonResource
    {
        $this->authorize('schedule_show');
        $data = ScheduleShowData::fromRequest($request);
        $schedule = $service->show($data, $id, $request->user()->account_id);
        clock($schedule->toArray());
        return SchedulesResource::make($schedule);
    }
}
