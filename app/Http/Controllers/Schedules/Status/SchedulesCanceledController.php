<?php

namespace App\Http\Controllers\Schedules\Status;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Schedule\Status\ScheduleCanceledRequest;
use App\Services\Application\Schedules\Schedule\DTO\ScheduleStatusData;
use App\Services\Application\Schedules\Status\CanceledService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SchedulesCanceledController extends Controller
{
    public function __invoke(ScheduleCanceledRequest $request, int $id, CanceledService $service): JsonResponse
    {
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
