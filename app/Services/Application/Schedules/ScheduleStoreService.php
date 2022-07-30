<?php

namespace App\Services\Application\Schedules;

use App\Enums\SchedulesStatusEnum;
use App\Enums\SchedulesTypesEnum;
use App\Models\Clients\Client;
use App\Models\Clients\Pet;
use App\Models\Schedules\Schedule;
use App\Models\User;
use App\Rules\AccountHasEntityRule;
use App\Rules\Schedule\CanBookAScheduleRule;
use App\Services\Application\Schedules\DTO\ScheduleStoreData;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class ScheduleStoreService extends BaseService
{

    public function store(ScheduleStoreData $data, User $user): Builder|Model
    {
        $data->account_id = $user->account_id;
        $this->validate($data);

        return Schedule::query()->create($data->toArray());
    }

    /**
     * @throws ValidationException
     */
    private function validate(ScheduleStoreData $data): void
    {
        Validator::make($data->toArray(), [
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
                new CanBookAScheduleRule($data->user_id, $data->duration)
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