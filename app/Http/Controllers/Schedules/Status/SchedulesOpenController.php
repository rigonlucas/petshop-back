<?php

namespace App\Http\Controllers\Schedules\Status;

use App\Http\Controllers\Controller;
use App\Services\Application\Schedules\Schedule\DTO\ScheduleStatusData;
use App\Services\Application\Schedules\Status\ScheduledService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SchedulesOpenController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @param ScheduledService $service
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, int $id, ScheduledService $service): JsonResponse
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
