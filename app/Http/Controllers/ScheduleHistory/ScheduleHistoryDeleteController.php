<?php

namespace App\Http\Controllers\ScheduleHistory;

use App\Http\Controllers\Controller;
use App\Services\Application\ScheduleHistory\DTO\ScheduleHistoryDeleteData;
use App\Services\Application\ScheduleHistory\ScheduleHistoryDeleteService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ScheduleHistoryDeleteController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @param int $ScheduleHistoryId
     * @param ScheduleHistoryDeleteService $service
     * @return Response
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function __invoke(Request $request, int $id, int $ScheduleHistoryId, ScheduleHistoryDeleteService $service): Response
    {
        $this->authorize('schedule_delete');
        $data = new ScheduleHistoryDeleteData();
        $data->schedule_history_id = $ScheduleHistoryId;
        $data->schedule_id = $id;//scheduleId
        $data->account_id = $request->user()->account_id;

        $service->delete($data);

        return response()->noContent();
    }
}
