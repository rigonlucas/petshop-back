<?php

namespace App\Http\Controllers\Schedules\Schedule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Schedule\ScheduleStoreRequest;
use App\Models\User;
use App\Services\Application\Schedules\Schedule\CreateRecurrenceService;
use App\Services\Application\Schedules\Schedule\CreateVaccineService;
use App\Services\Application\Schedules\Schedule\DTO\RecurrenceData;
use App\Services\Application\Schedules\Schedule\DTO\ScheduleData;
use App\Services\Application\Schedules\Schedule\DTO\VaccineData;
use App\Services\Application\Schedules\Schedule\ScheduleStoreService;
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
     * @throws AuthorizationException
     */
    public function __invoke(ScheduleStoreRequest $request, ScheduleStoreService $service): JsonResponse
    {
        $this->authorize('schedule_create');
        /** @var User $user */
        $user = $request->user();
        $data = ScheduleData::fromRequest($request);
        $recurrencies = $request->get('recurrence');
        $vaccines = $request->get('vaccine');

        $schedule = DB::transaction(function () use ($service, $data, $recurrencies, $user, $vaccines) {
            $schedule = $service->store($data, $user);

            if (!empty($recurrencies)) {
                $recurrenciesData = RecurrenceData::arrayOf($recurrencies);

                /** @var CreateRecurrenceService $recurrenceService */
                $recurrenceService = app(CreateRecurrenceService::class);
                $recurrenceService->create($schedule, $recurrenciesData, $user);
            }

            if (!empty($vaccines)) {
                $vaccinesData = VaccineData::arrayOf($vaccines);

                /** @var CreateVaccineService $vaccineService */
                $vaccineService = app(CreateVaccineService::class);
                $vaccineService->create($schedule, $vaccinesData);
            }

            return $schedule;
        });

        return response()->json(['data' => $schedule], ResponseAlias::HTTP_CREATED);
    }
}
