<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Schedules\SchedulesResource;
use App\Services\Admin\Schedules\ScheduleListService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ScheduleController extends Controller
{
    public function index(Request $request, ScheduleListService $service): AnonymousResourceCollection
    {
        $includes = $request->query('include', '');
        $schedules = $service
            ->setRequestedIncludes(explode(',', $includes))
            ->openSchedules()->paginate($request->query('per_page', 10));
        return SchedulesResource::collection($schedules);
    }
}
