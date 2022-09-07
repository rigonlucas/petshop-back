<?php

namespace App\Http\Controllers\Schedules\Status;

use App\Http\Controllers\Controller;
use App\Services\Application\Schedules\DTO\ScheduleStatusData;
use App\Services\Application\Schedules\Status\ScheduleCanceledService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SchedulesCanceledController extends Controller
{
    public function __invoke(Request $request, int $id, ScheduleCanceledService $service)
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
            ResponseAlias::HTTP_OK);
    }
}
