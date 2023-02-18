<?php

namespace App\Http\Controllers\Schedules\Schedule;

use App\Actions\Application\Schedules\Schedule\CreateRecurrenceAction;
use App\Actions\Application\Schedules\Schedule\CreateVaccineAction;
use App\Actions\Application\Schedules\Schedule\DTO\RecurrenceData;
use App\Actions\Application\Schedules\Schedule\DTO\ScheduleData;
use App\Actions\Application\Schedules\Schedule\DTO\VaccineData;
use App\Actions\Application\Schedules\Schedule\ScheduleStoreAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Schedule\ScheduleStoreRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ScheduleStoreController extends Controller
{
    public function __invoke(ScheduleStoreRequest $request, ScheduleStoreAction $service): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $data = ScheduleData::fromRequest($request);
        $recurrencies = $request->get('recurrence');
        $vaccines = $request->get('vaccine');

        $schedule = DB::transaction(function () use ($service, $data, $recurrencies, $user, $vaccines) {
            $schedule = $service->store($data, $user);

            if (!empty($recurrencies)) {
                $recurrenciesData = RecurrenceData::arrayOf($recurrencies);

                /** @var CreateRecurrenceAction $recurrenceService */
                $recurrenceService = app(CreateRecurrenceAction::class);
                $recurrenceService->create($schedule, $recurrenciesData, $user);
            }

            if (!empty($vaccines)) {
                $vaccinesData = VaccineData::arrayOf($vaccines);

                /** @var CreateVaccineAction $vaccineService */
                $vaccineService = app(CreateVaccineAction::class);
                $vaccineService->create($schedule, $vaccinesData);
            }

            return $schedule;
        });

        return response()->json(['data' => $schedule], ResponseAlias::HTTP_CREATED);
    }
}
