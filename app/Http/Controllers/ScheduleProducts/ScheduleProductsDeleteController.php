<?php

namespace App\Http\Controllers\ScheduleProducts;

use App\Http\Controllers\Controller;
use App\Services\Application\ScheduleProducts\DTO\ScheduleProductDeleteData;
use App\Services\Application\ScheduleProducts\ScheduleProductDeleteService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ScheduleProductsDeleteController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function __invoke(
        Request $request,
        int $id,
        int $scheduleProductId,
        ScheduleProductDeleteService $service
    ) {
        $data = new ScheduleProductDeleteData();
        $data->schedule_id = $id;
        $data->schedule_product_id = $scheduleProductId;
        $data->account_id = $request->user()->account_id;

        $service->delete($data);

        return response()->noContent();
    }
}
