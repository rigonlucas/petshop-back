<?php

namespace App\Http\Controllers\ScheduleHistory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\ScheduleHistory\ScheduleHistoryStoreRequest;
use App\Services\Application\ScheduleHistory\DTO\ScheduleHistoryStoreData;
use App\Services\Application\ScheduleHistory\ScheduleHistoryStoreService;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ScheduleHistoryStoreController extends Controller
{
    public function __invoke(ScheduleHistoryStoreRequest $request, int $id, ScheduleHistoryStoreService $service)
    {
        $data = ScheduleHistoryStoreData::fromRequest($request);
        $data->schedule_id = $id;
        $data->account_id = $request->user()->account_id;
        $result = $service->store($data);
        return response()->json([$result], ResponseAlias::HTTP_CREATED);
    }
}
