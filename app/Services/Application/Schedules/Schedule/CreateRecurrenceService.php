<?php

namespace App\Services\Application\Schedules\Schedule;

use App\Enums\SchedulesStatusEnum;
use App\Models\ScheduleRecurrence;
use App\Models\Schedules\Schedule;
use App\Models\Schedules\ScheduleHasProduct;
use App\Models\User;
use App\Rules\Schedule\CanBookAScheduleRule;
use App\Services\Application\Schedules\Schedule\DTO\RecurrenceData;
use App\Services\Application\Schedules\Schedule\DTO\ScheduleData;
use App\Services\Application\Schedules\Schedule\DTO\ScheduleProductData;
use App\Services\BaseService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CreateRecurrenceService extends BaseService
{
    public function __construct(private ScheduleStoreService $scheduleStoreService)
    {
    }

    /**
     * @param RecurrenceData[] $recurrencies
     * @throws ValidationException
     */
    public function create(Schedule $schedule, array $recurrencies, User $user): Schedule
    {
        foreach ($recurrencies as $recurrence) {
            $this->validate($recurrence);
        }

        $recurrence = new ScheduleRecurrence();
        $recurrence->type = 1;
        $recurrence->account_id = $user->account_id;
        $recurrence->save();

        foreach ($recurrencies as $recurrence) {
            $scheduleData = new ScheduleData();
            $scheduleData->start_at = $recurrence->start_at;
            $scheduleData->duration = $recurrence->duration;
            $scheduleData->status = SchedulesStatusEnum::SCHEDULED->value;
            $scheduleData->type = $schedule->type;
            $scheduleData->client_id = $schedule->client_id;
            $scheduleData->pet_id = $schedule->pet_id;
            $scheduleData->description = $schedule->description;
            $scheduleData->products = $schedule->hasProducts->map(
                fn(ScheduleHasProduct $hasProduct) => new ScheduleProductData($hasProduct->toArray())
            )->toArray();
            $this->scheduleStoreService->store($scheduleData, $user);
        }

        return $schedule;
    }

    /**
     * @throws ValidationException
     */
    private function validate(RecurrenceData $data)
    {
        Validator::make($data->toArray(), [
            "duration" => [
                'required',
                'min:1'
            ],
            "start_at" => [
                Rule::requiredIf($data->user_id),
                'date_format:Y-m-d H:i:s',
                new CanBookAScheduleRule($data->user_id, $data->duration)
            ],
        ])->validate();
    }
}