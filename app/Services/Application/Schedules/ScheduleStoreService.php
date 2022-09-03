<?php

namespace App\Services\Application\Schedules;

use App\Enums\SchedulesStatusEnum;
use App\Enums\SchedulesTypesEnum;
use App\Models\Clients\Client;
use App\Models\Clients\Pet;
use App\Models\Products\Product;
use App\Models\Schedules\Schedule;
use App\Models\Schedules\ScheduleHasProduct;
use App\Models\User;
use App\Rules\AccountHasEntityRule;
use App\Rules\Schedule\CanBookAScheduleRule;
use App\Services\Application\Schedules\DTO\ScheduleStoreData;
use App\Services\Application\Schedules\Validators\ScheduleProductsValidator;
use App\Services\Application\Schedules\Validators\ScheduleRecurrenceValidator;
use App\Services\Application\Schedules\Validators\ScheduleValidator;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class ScheduleStoreService extends BaseService
{

    public function store(ScheduleStoreData $data, User $user): Builder|Model
    {
        $data->account_id = $user->account_id;
        $this->validate($data);
        return DB::transaction(function () use ($data) {
            /** @var Schedule $schedule */
            $schedule = Schedule::query()->create($data->toArray());
            $this->addProducts($data, $schedule);
            $this->addRecurrence($data, $schedule);

            return $schedule;
        });
    }

    /**
     * @throws ValidationException
     */
    private function validate(ScheduleStoreData $data): void
    {
        Validator::make($data->toArray(), [
            ...(new ScheduleValidator())->validations($data),
            ...(new ScheduleProductsValidator())->validations($data),
            ...(new ScheduleRecurrenceValidator())->validations($data),
        ])->validate();
    }

    /**
     * @param ScheduleStoreData $data
     * @param Schedule $schedule
     * @return void
     */
    function  addProducts(ScheduleStoreData $data, Schedule $schedule): void
    {
        if ($data->products) {
            $schedule->products()->createMany(
                array_map(
                    function ($row) use ($schedule) {
                        return [...$row, ...['schedule_id' => $schedule->id]];
                    },
                    $data->products
                )
            );
        }
    }

    /**
     * @param ScheduleStoreData $data
     * @param Schedule $schedule
     * @return void
     */
    private function addRecurrence(ScheduleStoreData $data, Schedule $schedule): void
    {
       if ($data->recurrence) {
           $schedulesToCreate = array_map(
               function ($row) use ($schedule, $data) {
                   $newData = clone $data;
                   $newData->duration = $row['duration'];
                   $newData->start_at = $row['start_at'];
                   return clone $newData;
               },
               $data->recurrence
           );
           foreach ($schedulesToCreate as $schedule) {
               /** @var Schedule $created */
               $created = Schedule::query()->create($schedule->toArray());
               $this->addProducts($schedule, $created);
           }
       }
    }
}