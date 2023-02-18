<?php

namespace App\Actions\Application\Schedules\Schedule;

use App\Actions\Application\Schedules\Schedule\DTO\ScheduleData;
use App\Actions\Application\Schedules\Schedule\DTO\ScheduleProductData;
use App\Actions\Application\Schedules\Validations\ScheduleDateValidator;
use App\Actions\Application\Schedules\Validations\ScheduleProductsValidator;
use App\Actions\Application\Schedules\Validations\ScheduleValidator;
use App\Actions\BaseAction;
use App\Models\Schedules\Schedule;
use App\Models\Schedules\ScheduleHasProduct;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ScheduleStoreAction extends BaseAction
{
    public function store(ScheduleData $data, User $user): Schedule
    {
        $this->validate($user->account_id, $data);

        return DB::transaction(function () use ($data, $user) {
            $schedule = new Schedule($data->toArray());
            $schedule->account_id = $user->account_id;
            $schedule->save();

            $this->createProducts($schedule, $data);

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
        ])->validate();
    }

    private function createProducts(Schedule $schedule, ScheduleData $data): void
    {
        if (empty($data->products)) {
            return;
        }

        $scheduleHasProducts = array_map(function (ScheduleProductData $productData) use ($schedule) {
            $hasProduct = new ScheduleHasProduct();
            $hasProduct->fill($productData->toArray());
            return $hasProduct;
        }, $data->products);

        $schedule->hasProducts()->saveMany($scheduleHasProducts);

    }
}