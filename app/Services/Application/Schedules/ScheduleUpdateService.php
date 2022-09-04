<?php

namespace App\Services\Application\Schedules;

use App\Enums\SchedulesStatusEnum;
use App\Enums\SchedulesTypesEnum;
use App\Models\Clients\Client;
use App\Models\Clients\Pet;
use App\Models\Products\Product;
use App\Models\Schedules\Schedule;
use App\Models\User;
use App\Rules\AccountHasEntityRule;
use App\Rules\Schedule\CanUpdateBookAScheduleRule;
use App\Services\Application\Schedules\DTO\ScheduleUpdateData;
use App\Services\Application\Schedules\Validators\ScheduleDateValidator;
use App\Services\Application\Schedules\Validators\ScheduleProductsValidator;
use App\Services\Application\Schedules\Validators\ScheduleValidator;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class ScheduleUpdateService extends BaseService
{

    public function update(ScheduleUpdateData $data, User $user): int
    {
        $data->account_id = $user->account_id;
        $this->validate($data);

        return DB::transaction(function () use ($data) {
            /** @var Schedule $schedule */
            $schedule = Schedule::query()->find($data->schedule_id);
            return $schedule->update($data->except('schedule_id', 'products')->toArray());
        });
    }

    /**
     * @throws ValidationException
     */
    private function validate(ScheduleUpdateData $data): void
    {
        Validator::make($data->toArray(), [
            "schedule_id" => [
                'required',
                'int',
                'min:1',
                new AccountHasEntityRule(Schedule::class, $data->account_id),
            ],
            ...(new ScheduleValidator())->validations($data),
            ...(new ScheduleDateValidator())->validationsUpdate($data),
        ])->validate();
    }
}