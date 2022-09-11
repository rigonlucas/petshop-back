<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Schedule\ScheduleStoreRequest;
use App\Models\User;
use App\Services\Application\Schedules\CreateRecurrenceService;
use App\Services\Application\Schedules\DTO\RecurrenceData;
use App\Services\Application\Schedules\DTO\ScheduleData;
use App\Services\Application\Schedules\ScheduleStoreService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ScheduleStoreController extends Controller
{
    /**
     * @param ScheduleStoreRequest $request
     * @param ScheduleStoreService $service
     * @return JsonResponse
     * @throws UnknownProperties
     * @throws AuthorizationException
     */
    public function __invoke(ScheduleStoreRequest $request, ScheduleStoreService $service): JsonResponse
    {
        $this->authorize('schedule_create');
        /** @var User $user */
        $user = $request->user();
        $data = ScheduleData::fromRequest($request);
        $recurrencies = $request->get('recurrence');

        $schedule = DB::transaction(function () use ($service, $data, $recurrencies, $user) {
            $schedule = $service->store($data, $user);

            if (!empty($recurrencies)) {
                $recurrenciesData = RecurrenceData::arrayOf($recurrencies);

                /** @var CreateRecurrenceService $recurrenceService */
                $recurrenceService = app(CreateRecurrenceService::class);
                $recurrenceService->create($schedule, $recurrenciesData, $user);
            }

            return $schedule;
        });

        return response()->json(['data' => $schedule], ResponseAlias::HTTP_CREATED);
    }
}
