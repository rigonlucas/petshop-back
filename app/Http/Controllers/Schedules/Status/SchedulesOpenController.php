<?php

namespace App\Http\Controllers\Schedules\Status;

use App\Actions\Application\Schedules\Schedule\DTO\ScheduleStatusData;
use App\Actions\Application\Schedules\Status\ScheduledAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SchedulesOpenController extends Controller
{
    public function __invoke(Request $request, int $id, ScheduledAction $service): JsonResponse
    {
        $this->authorize('schedule_edit');
        $data = new ScheduleStatusData();
        $data->schedule_id = $id;
        return response()->json(
            [
                'row_updated' => $service->update($data, $request->user())
            ],
            ResponseAlias::HTTP_OK
        );
    }
}
