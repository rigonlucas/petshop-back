<?php

namespace App\Services\Application\Schedules;

use App\Enums\SchedulesStatusEnum;
use App\Enums\SchedulesTypesEnum;
use App\Models\Client;
use App\Models\Pet;
use App\Models\Schedule;
use App\Models\User;
use App\Rules\AccountHasEntityRule;
use App\Rules\Schedule\CanBookAScheduleRule;
use App\Rules\Schedule\CanUpdateAScheduleRule;
use App\Services\Application\Schedules\DTO\ScheduleUpdateData;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class ScheduleUpdateService extends BaseService
{

    public function update(ScheduleUpdateData $data, User $user): int
    {
        $data->account_id = $user->account_id;
        $this->validate($data);

        return Schedule::query()->where('id', '=', $data->schedule_id)
            ->update($data->except('schedule_id')->toArray());
    }

    /**
     * @throws ValidationException
     */
    public function validate(ScheduleUpdateData $data): void
    {
        Validator::make($data->toArray(), [
            "schedule_id" => [
                'required',
                'int',
                'min:1',
                new AccountHasEntityRule(Schedule::class, $data->account_id),
            ],
            "client_id" => [
                'required',
                'int',
                'min:1',
                new AccountHasEntityRule(Client::class, $data->account_id),
            ],
            "pet_id" => [
                'required',
                'int',
                'min:1',
                new AccountHasEntityRule(Pet::class, $data->account_id),
            ],
            "user_id" => [
                'required',
                'int',
                'min:1',
                new AccountHasEntityRule(User::class, $data->account_id),
            ],
            "type" => [
                'required',
                'int',
                'min:1',
                new Enum(SchedulesTypesEnum::class)
            ],
            "status" => [
                'required',
                'int',
                'min:1',
                new Enum(SchedulesStatusEnum::class)
            ],
            "duration" => [
                'required',
                'min:1'
            ],
            "start_at" => [
                'required',
                'date_format:Y-m-d H:i:s',
                new CanUpdateAScheduleRule($data->schedule_id, $data->user_id, $data->duration)
            ],
            "description" => [
                'nullable',
                'string',
                'min:1',
                'max:500'
            ],
        ])->validate();
    }
}