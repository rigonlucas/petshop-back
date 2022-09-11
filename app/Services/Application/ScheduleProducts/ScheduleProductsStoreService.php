<?php

namespace App\Services\Application\ScheduleProducts;

use App\Models\Products\Product;
use App\Models\Schedules\Schedule;
use App\Models\Schedules\ScheduleHasProduct;
use App\Models\User;
use App\Rules\AccountHasEntityRule;
use App\Rules\ScheduleProducts\ScheduleHasProductIdRule;
use App\Services\Application\ScheduleProducts\DTO\ScheduleProductsStoreData;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ScheduleProductsStoreService extends BaseService
{

    public function store(ScheduleProductsStoreData $data, User $user): ScheduleHasProduct
    {
        $data->account_id = $user->account_id;
        $this->validate($data);
        return DB::transaction(function () use ($data) {
            /** @var Schedule $schedule */
            $schedule = Schedule::byAccount($data->account_id)
                ->findOrFail($data->schedule_id);
            if (!$data->discount) {
                $data->discount = 0;
            }
            return $schedule->hasProducts()->create(
                $data->except('account_id')->toArray()
            );
        });
    }

    /**
     * @throws ValidationException
     */
    private function validate(ScheduleProductsStoreData $data): void
    {
        Validator::make($data->toArray(), [
            "schedule_id" => [
                'required',
                'integer',
                'gt:0'
            ],
            "product_id" => [
                'required',
                'integer',
                'gt:0',
                new AccountHasEntityRule(Product::class, $data->account_id),
            ],
            "quantity" => [
                'required',
                'integer',
                'gt:0'
            ],
            "price" => [
                'required',
                'numeric',
                'gt:-1'
            ],
            "discount" => [
                'nullable',
                'numeric',
                'gt:-1'
            ]
        ])->validate();
    }
}