<?php

namespace App\Services\Application\ScheduleHistory;

use App\Enums\PetRegisterTypesEnum;
use App\Models\Clients\Pet;
use App\Models\Schedules\Schedule;
use App\Models\Schedules\ScheduleHistory;
use App\Rules\AccountHasEntityRule;
use App\Services\Application\ScheduleHistory\DTO\ScheduleHistoryStoreData;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class ScheduleHistoryStoreService extends BaseService
{

    /**
     * @throws ValidationException
     */
    public function store(ScheduleHistoryStoreData $data): Model|Builder
    {
        $this->validate($data);
        return ScheduleHistory::query()
            ->where('schedule_id', '=', $data->schedule_id)
            ->create($data->toArray());
    }

    /**
     * @throws ValidationException
     */
    private function validate(ScheduleHistoryStoreData $data): void
    {
        Validator::make(
            $data->toArray(),
            [
                'register' => ['required', 'string', 'min:3', 'max:500'],
                'schedule_id' => [
                    'required',
                    'integer',
                    'min:1',
                    new AccountHasEntityRule(Schedule::class, $data->account_id),
                ],
                'type' => [
                    'required',
                    'numeric',
                    'gt:0',
                    'min:1',
                    new Enum(PetRegisterTypesEnum::class)
                ],
            ]
        )->validate();
    }
}