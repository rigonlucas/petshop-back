<?php

namespace App\Http\Controllers\ScheduleHistory;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleHistory\ScheduleHistoryResource;
use App\Services\Application\ScheduleHistory\DTO\ScheduleHistoryListData;
use App\Services\Application\ScheduleHistory\ScheduleHistoryListService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ScheduleHistoryIndexController extends Controller
{
    /**
     * @param Request $request
     * @param int $scheduleId
     * @param ScheduleHistoryListService $service
     * @return AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, int $scheduleId, ScheduleHistoryListService $service): AnonymousResourceCollection
    {
        $this->authorize('schedule_access');
        $data = ScheduleHistoryListData::fromRequest($request);
        $data->schedule_id = $scheduleId;
        if (!$request->has('order_direction')) {
            $data->order_direction = 'desc';
            $data->order_by = 'created_at';
        }
        $histories = $service->list($data, $request->user()->account_id);
        return ScheduleHistoryResource::collection($histories);
    }
}
