<?php

namespace App\Actions\Application\Schedules\Products;

use App\Actions\Application\Schedules\Products\DTO\ScheduleProductDeleteData;
use App\Actions\BaseAction;
use App\Models\Schedules\Schedule;
use App\Models\Schedules\ScheduleHasProduct;
use App\Rules\AccountHasEntityRule;
use App\Rules\Schedule\Product\ScheduleHasProductDeleteRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ScheduleProductDeleteAction extends BaseAction
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