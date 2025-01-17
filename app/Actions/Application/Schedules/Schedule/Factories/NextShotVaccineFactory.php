<?php

namespace App\Actions\Application\Schedules\Schedule\Factories;

use App\Models\Products\Vaccine;
use App\Actions\Application\Pets\Vaccines\DTO\PetVaccineStoreData;
use App\Actions\Application\Schedules\Schedule\DTO\VaccineData;
use Carbon\Carbon;

class NextShotVaccineFactory
{
    public function make(PetVaccineStoreData $petVaccineData, int $daysToBoosterDose): Carbon
    {
        if (!Carbon::canBeCreatedFromFormat($petVaccineData->schedule_date, 'd/m/Y')) {
            return Carbon::now()->addDays($daysToBoosterDose)->startOfDay()->setHour(9);
        }

        return Carbon::createFromFormat('d/m/Y', $petVaccineData->schedule_date)->startOfDay()->setHour(9);
    }
}