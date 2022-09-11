<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Schedule\ScheduleUpdateRequest;
use App\Services\Application\Schedules\DTO\Base\ScheduleData;
use App\Services\Application\Schedules\DTO\ScheduleUpdateData;
use App\Services\Application\Schedules\ScheduleUpdateService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ScheduleUpdateController extends Controller
{
    /**
     * @param ScheduleUpdateRequest $request
     * @param int $id
     * @param ScheduleUpdateService $service
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function __invoke(ScheduleUpdateRequest $request, int $id, ScheduleUpdateService $service): JsonResponse
    {
        $this->authorize('schedule_edit');
        $data = ScheduleData::fromRequest($request);
        $schedule = $service->update(
            $id,
            $data,
            $request->user()
        );
        return response()->json(['data' => $schedule], ResponseAlias::HTTP_OK);
    }
}
