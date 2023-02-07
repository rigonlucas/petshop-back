<?php

namespace App\Http\Controllers\Schedules\History;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Schedule\History\ScheduleHistoryStoreRequest;
use App\Services\Application\Schedules\History\DTO\ScheduleHistoryStoreData;
use App\Services\Application\Schedules\History\ScheduleHistoryStoreService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ScheduleHistoryStoreController extends Controller
{
    public function __invoke(ScheduleHistoryStoreRequest $request, int $id, ScheduleHistoryStoreService $service): JsonResponse
    {
        $data = ScheduleHistoryStoreData::fromRequest($request);
        $data->schedule_id = $id;
        $data->account_id = $request->user()->account_id;
        $result = $service->store($data);
        return response()->json(['data' => $result], ResponseAlias::HTTP_CREATED);
    }
}
