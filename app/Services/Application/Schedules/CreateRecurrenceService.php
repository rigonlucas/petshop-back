<?php

namespace App\Services\Application\Schedules;

use App\Enums\SchedulesStatusEnum;
use App\Models\ScheduleRecurrence;
use App\Models\Schedules\Schedule;
use App\Models\Schedules\ScheduleHasProduct;
use App\Models\User;
use App\Rules\Schedule\CanBookAScheduleRule;
use App\Services\Application\Schedules\DTO\RecurrenceData;
use App\Services\Application\Schedules\DTO\ScheduleData;
use App\Services\Application\Schedules\DTO\ScheduleProductData;
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
        foreach ($recurrencies as $recurrency) {
            $this->validate($recurrency);
        }

        $recurrency = new ScheduleRecurrence();
        $recurrency->type = 1;
        $recurrency->account_id = $user->account_id;
        $recurrency->save();

        foreach ($recurrencies as $recurrency) {
            $scheduleData = new ScheduleData();
            $scheduleData->start_at = $recurrency->start_at;
            $scheduleData->duration = $recurrency->duration;
            $scheduleData->status = SchedulesStatusEnum::OPEN->value;
            $scheduleData->type = $schedule->type;
            $scheduleData->client_id = $schedule->client_id;
            $scheduleData->pet_id = $schedule->pet_id;
            $scheduleData->description = $schedule->description;
            $scheduleData->products = $schedule->hasProducts->map(function (ScheduleHasProduct $hasProduct) {
                return new ScheduleProductData($hasProduct->toArray());
            });
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