<?php

namespace App\Http\Controllers\Schedules\Status;

use App\Enums\SchedulesStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Schedule\Status\ScheduleOpenRequest;
use App\Services\Application\Schedules\DTO\ScheduleStatusData;
use App\Services\Application\Schedules\Status\ScheduleArchivedService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SchedulesArchivedController extends Controller
{
    public function __invoke(Request $request, int $id, ScheduleArchivedService $service)
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
