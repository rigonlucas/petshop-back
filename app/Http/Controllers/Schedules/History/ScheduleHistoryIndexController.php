<?php

namespace App\Http\Controllers\Schedules\History;

use App\Actions\Application\Schedules\History\DTO\ScheduleHistoryListData;
use App\Actions\Application\Schedules\History\ScheduleHistoryListAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Schedules\ScheduleHistoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ScheduleHistoryIndexController extends Controller
{
    public function __invoke(
        Request $request,
        int $scheduleId,
        ScheduleHistoryListAction $service
    ): AnonymousResourceCollection {
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
