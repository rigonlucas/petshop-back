<?php

namespace App\Http\Controllers\ScheduleProducts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleProductsDeleteController extends Controller
{
    public function __invoke(Request $request, int $id, int $scheduleProductId)
    {
        dd($request->all(), $id, $scheduleProductId);
    }
}
