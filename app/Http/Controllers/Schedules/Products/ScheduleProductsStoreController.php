<?php

namespace App\Http\Controllers\Schedules\Products;

use App\Actions\Application\Schedules\Products\DTO\ScheduleProductsStoreData;
use App\Actions\Application\Schedules\Products\ScheduleProductsStoreAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Schedule\Products\ScheduleProductsStoreRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ScheduleProductsStoreController extends Controller
{
    public function __invoke(
        ScheduleProductsStoreRequest $request,
        int $id,
        ScheduleProductsStoreAction $service
    ): JsonResponse
    {
        $data = ScheduleProductsStoreData::fromRequest($request);
        $data->schedule_id = $id;
        $result = $service->store($data, $request->user());

        return response()->json(['data' => $result], ResponseAlias::HTTP_CREATED);
    }
}
