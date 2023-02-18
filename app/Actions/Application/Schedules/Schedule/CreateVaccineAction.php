<?php

namespace App\Actions\Application\Schedules\Schedule;

use App\Actions\Application\Schedules\Schedule\DTO\VaccineData;
use App\Actions\BaseAction;
use App\Models\Clients\PetVaccine;
use App\Models\Schedules\Schedule;
use App\Rules\Vaccine\IsAllVaccinesDifferentsRule;
use Illuminate\Support\Facades\Validator;

class CreateVaccineAction extends BaseAction
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