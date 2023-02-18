<?php

namespace App\Http\Controllers\Schedules\Status;

use App\Actions\Application\Schedules\Schedule\DTO\ScheduleStatusData;
use App\Actions\Application\Schedules\Status\ArchivedAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Schedule\Status\ScheduleOpenRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SchedulesArchivedController extends Controller
{
    public function __invoke(Request $request, int $id, ArchivedAction $service): JsonResponse
    {
        $data = new ScheduleStatusData();
        $data->schedule_id = $id;
        return response()->json(
            [
                'row_updated' => $service->update(
                    $data,
                    $request->user()
                )
            ],
            ResponseAlias::HTTP_OK
        );
    }
}
