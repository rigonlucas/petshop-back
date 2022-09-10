<?php

namespace App\Http\Controllers\ScheduleProducts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\ScheduleProducts\ScheduleProductsStoreRequest;
use App\Services\Application\ScheduleProducts\DTO\ScheduleProductsStoreData;
use App\Services\Application\ScheduleProducts\ScheduleProductsStoreService;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ScheduleProductsStoreController extends Controller
{
    /**
     * @throws UnknownProperties
     */
    public function __invoke(
        ScheduleProductsStoreRequest $request,
        int $id,
        ScheduleProductsStoreService $service
    ): JsonResponse
    {
        $this->authorize('schedule_create');
        $data = ScheduleProductsStoreData::fromRequest($request);
        $data->schedule_id = $id;
        $result = $service->store($data, $request->user());

        return response()->json(['data' => $result], ResponseAlias::HTTP_CREATED);
    }
}
