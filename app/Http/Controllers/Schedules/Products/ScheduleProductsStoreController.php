<?php

namespace App\Http\Controllers\Schedules\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Schedule\Products\ScheduleProductsStoreRequest;
use App\Services\Application\Schedules\Products\DTO\ScheduleProductsStoreData;
use App\Services\Application\Schedules\Products\ScheduleProductsStoreService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ScheduleProductsStoreController extends Controller
{
    /**
     * @param ScheduleProductsStoreRequest $request
     * @param int $id
     * @param ScheduleProductsStoreService $service
     * @return JsonResponse
     * @throws UnknownProperties
     * @throws AuthorizationException
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
