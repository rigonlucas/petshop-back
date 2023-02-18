<?php

namespace App\Http\Controllers\Schedules\Products;

use App\Actions\Application\Schedules\Products\DTO\ScheduleProductDeleteData;
use App\Actions\Application\Schedules\Products\ScheduleProductDeleteAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleProductsDeleteController extends Controller
{
    public function __invoke(
        Request $request,
        int $id,
        int $scheduleProductId,
        ScheduleProductDeleteAction $service
    ) {
        $data = new ScheduleProductDeleteData();
        $data->schedule_id = $id;
        $data->schedule_product_id = $scheduleProductId;
        $data->account_id = $request->user()->account_id;

        $service->delete($data);

        return response()->noContent();
    }
}
