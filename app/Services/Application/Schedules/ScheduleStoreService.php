<?php

namespace App\Services\Application\Schedules;

use App\Models\ScheduleRecurrence;
use App\Models\Schedules\Schedule;
use App\Models\User;
use App\Services\Application\Schedules\DTO\Base\ScheduleData;
use App\Services\Application\Schedules\DTO\ScheduleStoreData;
use App\Services\Application\Schedules\Validations\ScheduleDateValidator;
use App\Services\Application\Schedules\Validations\ScheduleProductsValidator;
use App\Services\Application\Schedules\Validations\ScheduleRecurrenceValidator;
use App\Services\Application\Schedules\Validations\ScheduleValidator;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ScheduleStoreService extends BaseService
{
    public function store(ScheduleData $data, User $user): Builder|Model
    {
        $this->validate($user->account_id, $data);
        return DB::transaction(function () use ($data, $user) {
            if ($data->recurrence) {
                $recurrence = ScheduleRecurrence::query()->create([
                    'type' => 1
                ]);
                $data->schedule_recurrence_id = $recurrence->id;
            }

            /** @var Schedule $schedule */
            $schedule = new Schedule($data->toArray());
            $schedule->account_id = $user->account_id;
            $schedule->save();

            $this->addProducts($data, $schedule);
            $this->addRecurrence($data, $schedule);

            return $schedule;
        });
    }

    /**
     * @throws ValidationException
     */
    private function validate(int $account_id, ScheduleData $data): void
    {
        Validator::make($data->toArray(), [
            ...(new ScheduleValidator())->validations($account_id),
            ...(new ScheduleDateValidator())->validationsStore($data),
            ...(new ScheduleProductsValidator())->validations($account_id),
            ...(new ScheduleRecurrenceValidator())->validations($data),
        ])->validate();
    }

    private function addProducts(ScheduleData $data, Schedule $schedule): void
    {
        if ($data->products) {
            $schedule->products()->createMany(
                array_map(
                    function ($row) use ($schedule) {
                        if (!$row['discount']) {
                            $row['discount'] = 0;
                        }
                        return [
                            ...$row,
                            ...[
                                'schedule_id' => $schedule->id,
                                'schedule_resource_id' => $schedule->schedule_resource_id
                            ]
                        ];
                    },
                    $data->products
                )
            );
        }
    }

    private function addRecurrence(ScheduleData $data, Schedule $schedule): void
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