<?php

namespace App\Http\Controllers\Schedules\Status;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Schedule\Status\ScheduleCanceledRequest;
use App\Services\Application\Schedules\Schedule\DTO\ScheduleStatusData;
use App\Services\Application\Schedules\Status\ScheduleCanceledService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SchedulesCanceledController extends Controller
{
    /**
     * @param ScheduleCanceledRequest $request
     * @param int $id
     * @param ScheduleCanceledService $service
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function __invoke(ScheduleCanceledRequest $request, int $id, ScheduleCanceledService $service): JsonResponse
    {
        $this->authorize('schedule_edit');
        $data = ScheduleStatusData::fromRequest($request);
        $data->schedule_id = $id;
        return response()->json(
            [
                'row_updated' => $service->update(
                    $data,
                    $request->user()
                )
            ],
            ResponseAlias::HTTP_OK);
    }
}
