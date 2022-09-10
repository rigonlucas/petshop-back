<?php

namespace App\Http\Controllers\Schedules\Status;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Schedule\Status\ScheduleFinishedRequest;
use App\Services\Application\Schedules\DTO\ScheduleStatusData;
use App\Services\Application\Schedules\Status\ScheduleFinishedService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SchedulesFinishedController extends Controller
{
    /**
     * @param ScheduleFinishedRequest $request
     * @param int $id
     * @param ScheduleFinishedService $service
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function __invoke(ScheduleFinishedRequest $request, int $id, ScheduleFinishedService $service): JsonResponse
    {
        $this->authorize('schedule_edit');
        $data = ScheduleStatusData::fromRequest($request);
        $data->schedule_id = $id;
        return response()->json(
            [
                'row_updated' =>
                    $service->update(
                        $data,
                        $request->user()
                    )
                ],
            ResponseAlias::HTTP_OK
        );
    }
}
