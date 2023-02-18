<?php

namespace App\Http\Controllers\Schedules\History;

use App\Actions\Application\Schedules\History\DTO\ScheduleHistoryDeleteData;
use App\Actions\Application\Schedules\History\ScheduleHistoryDeleteAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ScheduleHistoryDeleteController extends Controller
{
    public function __invoke(
        Request $request,
        int $id,
        int $scheduleHistoryId,
        ScheduleHistoryDeleteAction $service
    ): Response {
        $data = new ScheduleHistoryDeleteData();
        $data->schedule_history_id = $scheduleHistoryId;
        $data->schedule_id = $id;//scheduleId
        $data->account_id = $request->user()->account_id;

        $service->delete($data);

        return response()->noContent();
    }
}
