<?php

namespace App\Actions\Application\Schedules\Schedule\Factories;

use App\Enums\SchedulesStatusEnum;
use App\Enums\SchedulesTypesEnum;
use App\Models\Products\Vaccine;
use App\Actions\Application\Pets\Vaccines\DTO\PetVaccineStoreData;
use App\Actions\Application\Schedules\Schedule\DTO\ScheduleData;
use Carbon\Carbon;

class DataScheduleFactory
{
    public function make(PetVaccineStoreData $data): ScheduleData
    {
        $dataSchedule = new ScheduleData();
        $dataSchedule->status = SchedulesStatusEnum::SCHEDULED->value;
        $dataSchedule->pet_id = $data->pet_id;
        $dataSchedule->client_id = $data->pet_id;
        $dataSchedule->user_id = null;
        $dataSchedule->type = SchedulesTypesEnum::VETERINARIAN->value;
        $dataSchedule->duration = 30;
        $dataSchedule->start_at = $data->schedule_date;

        return $dataSchedule;
    }
}