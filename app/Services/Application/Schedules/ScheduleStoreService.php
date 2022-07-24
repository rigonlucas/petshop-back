<?php

namespace App\Services\Application\Schedules;

use App\Enums\SchedulesStatusEnum;
use App\Enums\SchedulesTypesEnum;
use App\Models\Client;
use App\Models\Pet;
use App\Models\Schedule;
use App\Models\User;
use App\Rules\Account\AccountHasClientRule;
use App\Rules\AccountHasEntityRule;
use App\Rules\Pet\PetHasClientRule;
use App\Rules\Schedule\CanBookAnScheduleRule;
use App\Services\Application\Clients\Validators\AccountClientValidator;
use App\Services\Application\Pets\Validator\AccountPetValidator;
use App\Services\Application\Schedules\DTO\ScheduleStoreData;
use App\Services\BaseService;
use Carbon\Carbon;
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
        $data->finish_at = Carbon::create($data->start_at)
            ->addMinutes($data->duration);
        $this->validate($data);

        return Schedule::query()->create($data->toArray());
    }

    /**
     * @throws ValidationException
     */
    public function validate(ScheduleStoreData $data): void
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
                new CanBookAnScheduleRule($data->user_id, $data->duration)
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