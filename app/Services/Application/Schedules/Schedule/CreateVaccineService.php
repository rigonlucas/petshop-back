<?php

namespace App\Services\Application\Schedules\Schedule;

use App\Enums\SchedulesStatusEnum;
use App\Models\Clients\PetVaccine;
use App\Models\ScheduleRecurrence;
use App\Models\Schedules\Schedule;
use App\Models\Schedules\ScheduleHasProduct;
use App\Models\User;
use App\Rules\Schedule\CanBookAScheduleRule;
use App\Rules\Vaccine\IsAllVaccinesDifferentsRule;
use App\Services\Application\Schedules\Schedule\DTO\RecurrenceData;
use App\Services\Application\Schedules\Schedule\DTO\ScheduleData;
use App\Services\Application\Schedules\Schedule\DTO\ScheduleProductData;
use App\Services\Application\Schedules\Schedule\DTO\VaccineData;
use App\Services\BaseService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CreateVaccineService extends BaseService
{
    /**
     * @param Schedule $schedule
     * @param array $vaccines
     * @return Schedule
     */
    public function create(Schedule $schedule, array $vaccines): Schedule
    {
        $vaccinesIds = array_map(function ($value) {
            return $value->vaccine_id;
        }, $vaccines);

        /** @var VaccineData $vaccine */
        foreach ($vaccines as $vaccine) {
            $this->validate($vaccine, $vaccinesIds);
        }

        foreach ($vaccines as $vaccine) {
            $petVaccine = new PetVaccine();
            $petVaccine->pet_id = $schedule->pet_id;
            $petVaccine->vaccine_id = $vaccine->vaccine_id;
            $petVaccine->schedule_id = $schedule->id;
            $petVaccine->save();
        }

        return $schedule;
    }

    private function validate(VaccineData $data, array $vaccines)
    {
        Validator::make($data->toArray(), [
            "applied" => [
                'nullable',
                'boolean'
            ],
            "vaccine_id" => [
                'bail',
                'required',
                'exists:vaccines,id',
                new IsAllVaccinesDifferentsRule($vaccines)
            ],
        ])->validate();
    }
}