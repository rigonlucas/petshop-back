<?php

namespace App\Http\Controllers\Schedules\Exports;

use App\Enums\SchedulesStatusEnum;
use App\Exceptions\Enum\Schedules\InvalidEnumScheduleStatusException;
use App\Http\Controllers\Controller;
use App\Jobs\Schedules\SchedulesExportJob;
use App\Services\Application\Exports\Schedules\SchedulesStatusExportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SchedulesExportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param int $status
     * @param SchedulesStatusExportService $service
     * @return JsonResponse
     * @throws InvalidEnumScheduleStatusException
     */
    public function __invoke(Request $request, int $status): JsonResponse
    {
        $user = $request->user()->load('account');
        $enum = SchedulesStatusEnum::tryFrom($status);
        if (!$enum) {
            throw new InvalidEnumScheduleStatusException();
        }
        SchedulesExportJob::dispatch($user, $enum);
        return response()->json();
    }
}
