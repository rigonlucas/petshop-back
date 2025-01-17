<?php

namespace App\Http\Controllers\Pet\Vaccine;

use App\Actions\Application\Pets\Vaccines\DTO\PetVaccineStoreData;
use App\Actions\Application\Pets\Vaccines\PetVaccinesStoreAction;
use App\Actions\Application\Schedules\Schedule\Factories\DataScheduleFactory;
use App\Actions\Application\Schedules\Schedule\Factories\NextShotVaccineFactory;
use App\Actions\Application\Schedules\Schedule\ScheduleStoreAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Pet\Vaccine\PetVaccineStoreRequest;
use App\Models\Products\Vaccine;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PetVaccineStoreController extends Controller
{
    public function __invoke(
        PetVaccineStoreRequest $request,
        PetVaccinesStoreAction $servicePetVacineStore,
        ScheduleStoreAction $serviceScheduleStore
    ): JsonResponse {
        $dataPetVaccine = PetVaccineStoreData::fromRequest($request);
        $result = DB::transaction(function () use ($servicePetVacineStore, $serviceScheduleStore, $dataPetVaccine, $request) {
            $scheduleResult = [];
            if ($dataPetVaccine->schedule_new) {
                /** @var Vaccine $vaccineModel */
                $vaccineModel = Vaccine::query()
                    ->select('type', 'number_first_shoot', 'number_first_shoot_days', 'days_to_booster_dose')
                    ->find($dataPetVaccine->vaccine_id);
                $dataSchedule = (new DataScheduleFactory())->make($dataPetVaccine);
                $dataSchedule->start_at = (new NextShotVaccineFactory())
                    ->make($dataPetVaccine, $vaccineModel->days_to_booster_dose);

                $scheduleResult = $serviceScheduleStore->store($dataSchedule, $request->user());

                $dataPetVaccine->schedule_id = $scheduleResult->id;
            }
            $petVacineResult = $servicePetVacineStore->store(
                $dataPetVaccine,
                $request->user()->account_id
            );
            return [
                'pet_vaccine' => $petVacineResult,
                'schedule' => $scheduleResult
            ];
        });
        return response()->json(['data' => $result], ResponseAlias::HTTP_CREATED);
    }
}
