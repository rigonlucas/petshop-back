<?php

namespace App\Http\Controllers\ScheduleHistory;

use App\Http\Controllers\Controller;
use App\Services\Application\ScheduleHistory\DTO\ScheduleHistoryDeleteData;
use App\Services\Application\ScheduleHistory\ScheduleHistoryDeleteService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ScheduleHistoryDeleteController extends Controller
{
    public function __invoke(Request $request, int $id, int $ScheduleHistoryId, ScheduleHistoryDeleteService $service): Response
    {
        $data = new ScheduleHistoryDeleteData();
        $data->schedule_history_id = $ScheduleHistoryId;
        $data->schedule_id = $id;//scheduleId
        $data->account_id = $request->user()->account_id;

        $result = $service->delete($data);

        return response()->noContent();
    }
}
