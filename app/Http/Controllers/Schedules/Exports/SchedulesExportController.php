<?php

namespace App\Http\Controllers\Schedules\Exports;

use App\Enums\SchedulesStatusEnum;
use App\Exceptions\Enum\Schedules\InvalidEnumScheduleStatusException;
use App\Http\Controllers\Controller;
use App\Jobs\Schedules\SchedulesExportJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SchedulesExportController extends Controller
{
    public function __invoke(Request $request, int $status): JsonResponse
    {
        $enum = SchedulesStatusEnum::tryFrom($status);
        if (!$enum) {
            throw new InvalidEnumScheduleStatusException();
        }
        SchedulesExportJob::dispatch($request->user()->load('account:id,uuid'), $enum);
        return response()->json();
    }
}
