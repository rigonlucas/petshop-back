<?php

namespace App\Http\Controllers\Schedules\Products;

use App\Http\Controllers\Controller;
use App\Services\Application\Schedules\Products\DTO\ScheduleProductDeleteData;
use App\Services\Application\Schedules\Products\ScheduleProductDeleteService;
use Illuminate\Http\Request;

class ScheduleProductsDeleteController extends Controller
{
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
