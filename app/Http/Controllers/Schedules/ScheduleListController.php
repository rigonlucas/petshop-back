<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\Controller;
use App\Http\Resources\Schedules\SchedulesResource;
use App\Services\Application\Schedules\DTO\ScheduleListData;
use App\Services\Application\Schedules\ScheduleListService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ScheduleListController extends Controller
{
    public function __invoke(Request $request, ScheduleListService $service): AnonymousResourceCollection
    {
        $data = ScheduleListData::fromRequest($request);
        $schedules = $service
            ->openSchedules($data)
            ->getQuery()
            ->paginate($data->per_page ?? 10);
        return SchedulesResource::collection($schedules);
    }
}
