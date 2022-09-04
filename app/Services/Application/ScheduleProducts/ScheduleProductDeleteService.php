<?php

namespace App\Services\Application\ScheduleProducts;

use App\Models\Schedules\Schedule;
use App\Models\Schedules\ScheduleHasProduct;
use App\Rules\AccountHasEntityRule;
use App\Rules\ScheduleProducts\ScheduleHasProductDeleteRule;
use App\Services\Application\ScheduleProducts\DTO\ScheduleProductDeleteData;
use App\Services\BaseService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ScheduleProductDeleteService extends BaseService
{

    /**
     * @throws ValidationException
     */
    public function delete(ScheduleProductDeleteData $data): bool
    {
        $this->validate($data);
        return ScheduleHasProduct::query()
            ->where('id', '=', $data->schedule_product_id)
            ->where('schedule_id', '=', $data->schedule_id)
            ->delete();
    }

    /**
     * @throws ValidationException
     */
    private function validate(ScheduleProductDeleteData $data): void
    {
        Validator::make(
            $data->toArray(),
            [
                'schedule_id' => [
                    'required',
                    'integer',
                    'min:1',
                    new AccountHasEntityRule(Schedule::class, $data->account_id),
                    new ScheduleHasProductDeleteRule($data->schedule_product_id)
                ],
            ]
        )->validate();
    }
}