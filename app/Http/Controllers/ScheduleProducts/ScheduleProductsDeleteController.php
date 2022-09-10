<?php

namespace App\Http\Controllers\ScheduleProducts;

use App\Http\Controllers\Controller;
use App\Services\Application\ScheduleProducts\DTO\ScheduleProductDeleteData;
use App\Services\Application\ScheduleProducts\ScheduleProductDeleteService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ScheduleProductsDeleteController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @param int $scheduleProductId
     * @param ScheduleProductDeleteService $service
     * @return Response
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function __invoke(
        Request $request,
        int $id,
        int $scheduleProductId,
        ScheduleProductDeleteService $service
    ) {
        $this->authorize('schedule_edit');
        $data = new ScheduleProductDeleteData();
        $data->schedule_id = $id;
        $data->schedule_product_id = $scheduleProductId;
        $data->account_id = $request->user()->account_id;

        $service->delete($data);

        return response()->noContent();
    }
}
